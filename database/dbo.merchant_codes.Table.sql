USE [budget]
GO
/****** Object:  Table [dbo].[merchant_codes]    Script Date: 06.12.2018 22:45:37 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[merchant_codes](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[name] [varchar](100) NOT NULL,
	[id_operations_categories] [int] NOT NULL,
 CONSTRAINT [PK_merchant_codes] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
ALTER TABLE [dbo].[merchant_codes] ADD  CONSTRAINT [DF_merchant_codes_id_operations_categories]  DEFAULT ((3)) FOR [id_operations_categories]
GO
ALTER TABLE [dbo].[merchant_codes]  WITH CHECK ADD  CONSTRAINT [FK_merchant_codes_operations_categories] FOREIGN KEY([id_operations_categories])
REFERENCES [dbo].[operations_categories] ([id])
GO
ALTER TABLE [dbo].[merchant_codes] CHECK CONSTRAINT [FK_merchant_codes_operations_categories]
GO
