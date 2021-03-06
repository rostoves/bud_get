USE [budget]
GO
/****** Object:  Table [dbo].[descriptions]    Script Date: 21.05.2019 23:28:15 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[descriptions](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[description] [varchar](256) NOT NULL,
	[id_mcc_desc] [int] NULL,
 CONSTRAINT [PK_descriptions] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
ALTER TABLE [dbo].[descriptions]  WITH CHECK ADD  CONSTRAINT [FK_descriptions_merchant_codes] FOREIGN KEY([id_mcc_desc])
REFERENCES [dbo].[merchant_codes] ([id])
ON UPDATE CASCADE
ON DELETE SET NULL
GO
ALTER TABLE [dbo].[descriptions] CHECK CONSTRAINT [FK_descriptions_merchant_codes]
GO
