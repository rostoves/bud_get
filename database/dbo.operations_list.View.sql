USE [budget]
GO
/****** Object:  View [dbo].[operations_list]    Script Date: 17.02.2019 17:50:48 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[operations_list]
AS
SELECT        dbo.operations.id, dbo.operations.operation_date, dbo.operations.bargain_sum, dbo.descriptions.description, dbo.merchant_codes.name AS mcc, dbo.operations_categories.name AS category, 
                         dbo.operations_types.name AS type, dbo.operations.comment, dbo.merchant_codes.id AS mcc_id, dbo.operations.status, dbo.cards.id AS card_id
FROM            dbo.operations LEFT OUTER JOIN
                         dbo.descriptions ON dbo.operations.id_description = dbo.descriptions.id LEFT OUTER JOIN
                         dbo.cards ON dbo.operations.id_card = dbo.cards.id LEFT OUTER JOIN
                         dbo.merchant_codes LEFT OUTER JOIN
                         dbo.operations_categories LEFT OUTER JOIN
                         dbo.operations_types ON dbo.operations_categories.id_operations_types = dbo.operations_types.id ON dbo.merchant_codes.id_operations_categories = dbo.operations_categories.id ON 
                         dbo.operations.id_mcc = dbo.merchant_codes.id
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPane1', @value=N'[0E232FF0-B466-11cf-A24F-00AA00A3EFFF, 1.00]
Begin DesignProperties = 
   Begin PaneConfigurations = 
      Begin PaneConfiguration = 0
         NumPanes = 4
         Configuration = "(H (1[40] 4[20] 2[20] 3) )"
      End
      Begin PaneConfiguration = 1
         NumPanes = 3
         Configuration = "(H (1 [50] 4 [25] 3))"
      End
      Begin PaneConfiguration = 2
         NumPanes = 3
         Configuration = "(H (1 [50] 2 [25] 3))"
      End
      Begin PaneConfiguration = 3
         NumPanes = 3
         Configuration = "(H (4 [30] 2 [40] 3))"
      End
      Begin PaneConfiguration = 4
         NumPanes = 2
         Configuration = "(H (1 [56] 3))"
      End
      Begin PaneConfiguration = 5
         NumPanes = 2
         Configuration = "(H (2 [66] 3))"
      End
      Begin PaneConfiguration = 6
         NumPanes = 2
         Configuration = "(H (4 [50] 3))"
      End
      Begin PaneConfiguration = 7
         NumPanes = 1
         Configuration = "(V (3))"
      End
      Begin PaneConfiguration = 8
         NumPanes = 3
         Configuration = "(H (1[56] 4[18] 2) )"
      End
      Begin PaneConfiguration = 9
         NumPanes = 2
         Configuration = "(H (1 [75] 4))"
      End
      Begin PaneConfiguration = 10
         NumPanes = 2
         Configuration = "(H (1[66] 2) )"
      End
      Begin PaneConfiguration = 11
         NumPanes = 2
         Configuration = "(H (4 [60] 2))"
      End
      Begin PaneConfiguration = 12
         NumPanes = 1
         Configuration = "(H (1) )"
      End
      Begin PaneConfiguration = 13
         NumPanes = 1
         Configuration = "(V (4))"
      End
      Begin PaneConfiguration = 14
         NumPanes = 1
         Configuration = "(V (2))"
      End
      ActivePaneConfig = 0
   End
   Begin DiagramPane = 
      Begin Origin = 
         Top = 0
         Left = 0
      End
      Begin Tables = 
         Begin Table = "operations"
            Begin Extent = 
               Top = 114
               Left = 448
               Bottom = 244
               Right = 667
            End
            DisplayFlags = 280
            TopColumn = 4
         End
         Begin Table = "descriptions"
            Begin Extent = 
               Top = 156
               Left = 112
               Bottom = 252
               Right = 282
            End
            DisplayFlags = 280
            TopColumn = 0
         End
         Begin Table = "cards"
            Begin Extent = 
               Top = 9
               Left = 115
               Bottom = 139
               Right = 285
            End
            DisplayFlags = 280
            TopColumn = 0
         End
         Begin Table = "merchant_codes"
            Begin Extent = 
               Top = 85
               Left = 720
               Bottom = 217
               Right = 939
            End
            DisplayFlags = 280
            TopColumn = 0
         End
         Begin Table = "operations_categories"
            Begin Extent = 
               Top = 77
               Left = 1025
               Bottom = 190
               Right = 1218
            End
            DisplayFlags = 280
            TopColumn = 0
         End
         Begin Table = "operations_types"
            Begin Extent = 
               Top = 96
               Left = 1282
               Bottom = 192
               Right = 1452
            End
            DisplayFlags = 280
            TopColumn = 0
         End
      End
   End
   Begin SQLPane = 
   End
   Begin DataPane = 
      Begin ParameterDefaults = ""
      End
   End
   Begin CriteriaPane = 
      Begin ColumnWidths = 1' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'VIEW',@level1name=N'operations_list'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPane2', @value=N'1
         Column = 1590
         Alias = 900
         Table = 2490
         Output = 765
         Append = 1400
         NewValue = 1170
         SortType = 1350
         SortOrder = 1410
         GroupBy = 1350
         Filter = 1350
         Or = 1350
         Or = 1350
         Or = 1350
      End
   End
End
' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'VIEW',@level1name=N'operations_list'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPaneCount', @value=2 , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'VIEW',@level1name=N'operations_list'
GO
