USE [budget]
GO
/****** Object:  Table [dbo].[cards_balance]    Script Date: 24.11.2018 22:02:53 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[cards_balance](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[id_card] [int] NOT NULL,
	[id_operation] [int] NOT NULL,
	[operation_date] [datetime] NOT NULL,
	[bargain_sum] [decimal](18, 2) NOT NULL,
	[previous_balance] [decimal](18, 2) NULL,
	[balance]  AS ([previous_balance]+[bargain_sum]),
 CONSTRAINT [PK_cards_balance] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
