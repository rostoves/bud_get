USE [budget]
GO
/****** Object:  UserDefinedFunction [dbo].[check_operation_exist]    Script Date: 03.02.2019 18:36:57 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE FUNCTION [dbo].[check_operation_exist] 
(
	@operation_date varchar(max), 
	@description varchar(max),
	@bargain_sum varchar(max)
)
RETURNS int
AS
BEGIN
	DECLARE @id int

	SELECT @id = [id] FROM [dbo].[operations] WHERE 
	[operation_date] = CONVERT(datetime,LEFT(@operation_date,19),104) AND 
	[id_description] = (SELECT [id] FROM [dbo].[descriptions] D WHERE D.[description] = @description) AND 
	[bargain_sum] = CONVERT(DECIMAL(18,2),(REPLACE(@bargain_sum,',','.')))

	RETURN @id

END
GO
