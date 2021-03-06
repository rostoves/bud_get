USE [budget]
GO
/****** Object:  Table [dbo].[operations]    Script Date: 06.12.2018 22:45:37 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[operations](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[operation_date] [datetime] NULL,
	[id_card] [int] NULL,
	[status] [varchar](50) NULL,
	[operation_sum] [decimal](18, 2) NULL,
	[id_operation_cur] [int] NULL,
	[bargain_sum] [decimal](18, 2) NULL,
	[id_bargain_cur] [int] NULL,
	[cashback] [decimal](18, 2) NULL,
	[id_mcc] [int] NULL,
	[id_description] [int] NULL,
	[comment] [varchar](100) NULL,
	[import_date] [datetime] NULL,
 CONSTRAINT [PK_operations] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
ALTER TABLE [dbo].[operations] ADD  CONSTRAINT [DF_operations_import_date]  DEFAULT (getdate()) FOR [import_date]
GO
ALTER TABLE [dbo].[operations]  WITH CHECK ADD  CONSTRAINT [FK_operations_cards1] FOREIGN KEY([id_card])
REFERENCES [dbo].[cards] ([id])
GO
ALTER TABLE [dbo].[operations] CHECK CONSTRAINT [FK_operations_cards1]
GO
ALTER TABLE [dbo].[operations]  WITH CHECK ADD  CONSTRAINT [FK_operations_currencies] FOREIGN KEY([id_operation_cur])
REFERENCES [dbo].[currencies] ([id])
GO
ALTER TABLE [dbo].[operations] CHECK CONSTRAINT [FK_operations_currencies]
GO
ALTER TABLE [dbo].[operations]  WITH CHECK ADD  CONSTRAINT [FK_operations_currencies1] FOREIGN KEY([id_bargain_cur])
REFERENCES [dbo].[currencies] ([id])
GO
ALTER TABLE [dbo].[operations] CHECK CONSTRAINT [FK_operations_currencies1]
GO
ALTER TABLE [dbo].[operations]  WITH CHECK ADD  CONSTRAINT [FK_operations_descriptions] FOREIGN KEY([id_description])
REFERENCES [dbo].[descriptions] ([id])
GO
ALTER TABLE [dbo].[operations] CHECK CONSTRAINT [FK_operations_descriptions]
GO
ALTER TABLE [dbo].[operations]  WITH CHECK ADD  CONSTRAINT [FK_operations_merchant_codes] FOREIGN KEY([id_mcc])
REFERENCES [dbo].[merchant_codes] ([id])
GO
ALTER TABLE [dbo].[operations] CHECK CONSTRAINT [FK_operations_merchant_codes]
GO
