USE [budget]
GO
/****** Object:  Table [dbo].[cards]    Script Date: 17.02.2019 17:22:08 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[cards](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[number] [varchar](10) NOT NULL,
	[name] [varchar](50) NULL,
	[is_active] [int] NULL,
	[owner] [varchar](50) NULL,
	[bank] [varchar](20) NULL,
	[system] [varchar](20) NULL,
 CONSTRAINT [PK_cards] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
ALTER TABLE [dbo].[cards] ADD  CONSTRAINT [DF_cards_is_active]  DEFAULT ((1)) FOR [is_active]
GO
