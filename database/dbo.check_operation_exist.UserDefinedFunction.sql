USE [budget]
GO
/****** Object:  UserDefinedFunction [dbo].[check_operation_exist]    Script Date: 03.02.2019 0:15:28 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE FUNCTION [dbo].[check_operation_exist] 
(
	@operation_date varchar(max), 
	@category varchar(max),
	@bargain_sum varchar(max)
)
RETURNS int
AS
BEGIN
	DECLARE @id int

	SELECT @id = [id] FROM [dbo].[operations] WHERE 
	[operation_date] = CONVERT(datetime,LEFT(@operation_date,19),104) AND 
	[id_mcc] = (SELECT [id] FROM [dbo].[merchant_codes] MC WHERE MC.[name] = @category) AND 
	[bargain_sum] = CONVERT(DECIMAL(18,2),(REPLACE(@bargain_sum,',','.')))

	RETURN @id

END
GO
