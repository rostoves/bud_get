USE [budget]
GO
/****** Object:  StoredProcedure [dbo].[source_data_import]    Script Date: 06.12.2018 22:45:38 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[source_data_import] 
	@operation_date varchar(max), 
	@card varchar(max),
	@status varchar(max), 
	@operation_sum varchar(max), 
	@operation_cur varchar(max), 
	@bargain_sum varchar(max), 
	@bargain_cur varchar(max), 
	@category varchar(max), 
	@description varchar(max), 
	@cashback varchar(max),
	@comment varchar(max),
	@rowId varchar(max)
AS
BEGIN
	SET NOCOUNT ON;

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
		   ,[cashback]
		   ,[comment])
	
	VALUES (
		CONVERT(datetime,LEFT(@operation_date,19),104)
		,(SELECT [id] FROM [dbo].[cards] C WHERE C.[number] = @card)
		,@status
		,CONVERT(DECIMAL(18,2),(REPLACE(@operation_sum,',','.')))		
		,(SELECT [id] FROM [dbo].[currencies] CR WHERE CR.[code] = @operation_cur)
		,CONVERT(DECIMAL(18,2),(REPLACE(@bargain_sum,',','.')))
		,(SELECT [id] FROM [dbo].[currencies] CR WHERE CR.[code] = @bargain_cur)
		,(SELECT [id] FROM [dbo].[merchant_codes] MC WHERE MC.[name] = @category)
		,(SELECT [id] FROM [dbo].[descriptions] D WHERE D.[description] = @description)
		,CONVERT(DECIMAL(18,2),(REPLACE(@cashback,',','.')))
		,@comment
	)
END
GO
