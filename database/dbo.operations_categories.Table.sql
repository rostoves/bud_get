USE [budget]
GO
/****** Object:  Table [dbo].[operations_categories]    Script Date: 24.11.2018 22:02:53 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[operations_categories](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[name] [varchar](100) NOT NULL,
	[id_operations_types] [int] NOT NULL,
 CONSTRAINT [PK_operations_categories] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
ALTER TABLE [dbo].[operations_categories] ADD  CONSTRAINT [DF_operations_categories_id_operations_types]  DEFAULT ((1)) FOR [id_operations_types]
GO
ALTER TABLE [dbo].[operations_categories]  WITH CHECK ADD  CONSTRAINT [FK_operations_categories_operations_types] FOREIGN KEY([id_operations_types])
REFERENCES [dbo].[operations_types] ([id])
GO
ALTER TABLE [dbo].[operations_categories] CHECK CONSTRAINT [FK_operations_categories_operations_types]
GO
