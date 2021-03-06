USE [budget]
GO
/****** Object:  StoredProcedure [dbo].[csv_data_import]    Script Date: 06.12.2018 22:45:38 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[csv_data_import]  
	(@dir varchar(256) = 'D:\Downloads\operations.csv')
AS
BEGIN
	
	SET NOCOUNT ON;

    IF OBJECT_ID(N'TempDb..#temp_import','U') IS NOT NULL DROP TABLE #temp_import;

	CREATE TABLE #temp_import (
		[operation_date] [varchar](50) NULL,
		[bargain_date] [varchar](50) NULL,
		[card] [varchar](20) NULL,
		[status] [varchar](20) NULL,
		[operation_sum] [varchar](50) NULL,
		[operation_cur] [varchar](50) NULL,
		[bargain_sum] [varchar](50) NULL,
		[bargain_cur] [varchar](50) NULL,
		[cashback] [int] NULL,
		[category] [varchar](100) NULL,
		[mcc] [int] NULL,
		[description] [varchar](256) NULL,
		[bonuses] [varchar](50) NULL
	);

--	declare @dir varchar(256) = 'D:\Downloads\operations.csv';

	declare @sql varchar(max)
	set @sql = 
	'BULK INSERT #temp_import 
	FROM ''' + @dir + ''' 
	
	WITH ( 
	CODEPAGE = ''1251'',
	FIRSTROW = 2,
	FIELDTERMINATOR = ''";"'', 
	ROWTERMINATOR = ''"
"''
	);'

	exec (@sql);

--	select * from #temp_import;

	MERGE INTO [dbo].[merchant_codes] AS MC
	USING (SELECT DISTINCT [category] from #temp_import WHERE [category] IS NOT NULL) AS TI
	ON (TI.[category] = MC.[name])
	WHEN NOT MATCHED
		THEN INSERT (name) VALUES (TI.[category]);

	MERGE INTO [dbo].[descriptions] AS D
	USING (SELECT DISTINCT [description] from #temp_import WHERE [description] IS NOT NULL) AS TI
	ON (TI.[description] = D.[description])
	WHEN NOT MATCHED
		THEN INSERT ([description]) VALUES (TI.[description]);

	MERGE INTO [dbo].[currencies] AS C
	USING (SELECT DISTINCT [operation_cur] from #temp_import WHERE [operation_cur] IS NOT NULL) AS TI
	ON (TI.[operation_cur] = C.[code])
	WHEN NOT MATCHED
		THEN INSERT ([code]) VALUES (TI.[operation_cur]);

	MERGE INTO [dbo].[cards] AS CD
	USING (SELECT DISTINCT [card] from #temp_import WHERE [card] IS NOT NULL) AS TI
	ON (TI.[card] = CD.[number])
	WHEN NOT MATCHED
		THEN INSERT ([number]) VALUES (TI.[card]);

	
	INSERT INTO [dbo].[operations]
           ([operation_date]
           ,[id_card]
           ,[status]
           ,[operation_sum]
           ,[id_operation_cur]
           ,[bargain_sum]
           ,[id_bargain_cur]
           ,[id_mcc]
           ,[id_description]
		   ,[cashback])
	
	SELECT CONVERT(datetime,LEFT(operation_date,19))
		,(SELECT [id] FROM [dbo].[cards] C WHERE C.[number] = TI.[card])
		,[status]
		,CONVERT(DECIMAL(18,2),(REPLACE(operation_sum,',','.')))		
		,(SELECT [id] FROM [dbo].[currencies] CR WHERE CR.[code] = TI.[operation_cur])
		,CONVERT(DECIMAL(18,2),(REPLACE(bargain_sum,',','.')))
		,(SELECT [id] FROM [dbo].[currencies] CR WHERE CR.[code] = TI.[bargain_cur])
		,(SELECT [id] FROM [dbo].[merchant_codes] MC WHERE MC.[name] = TI.[category])
		,(SELECT [id] FROM [dbo].[descriptions] D WHERE D.[description] = TI.[description])
		,[cashback]
	FROM #temp_import TI

--	select * from #temp_import;
END
GO
