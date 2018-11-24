USE [budget]
GO
/****** Object:  Table [dbo].[descriptions]    Script Date: 24.11.2018 22:02:53 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[descriptions](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[description] [varchar](256) NOT NULL,
 CONSTRAINT [PK_descriptions] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
