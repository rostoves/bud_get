<?php

class Categories
{
    public static function getCategoriesList()
    {
        $result = Database::getInstance()->getColumns('*','[operations_categories]', ' ORDER BY [id_operations_types], [name]');
        Log::getLog()->trace($result);
        return $result;
    }

    public static function getMccList()
    {
        $result = Database::getInstance()->getColumns('*', '[merchant_codes]', ' ORDER BY [id_operations_categories], [name]');
        Log::getLog()->trace($result);
        return $result;
    }

    public static function updateMccCat($mccId, $column, $newMccCatId)
    {
        return Log::getLog()->info(Database::getInstance()->updateCellValue($column, $newMccCatId, '[id]', $mccId, '[merchant_codes]'));
    }

    public static function deleteMcc($idMcc, $newMcc)
    {
        Log::getLog()->info(Database::getInstance()->updateCellValue('[id_mcc]', $newMcc, '[id_mcc]', $idMcc, '[operations]'));
        Log::getLog()->info(Database::getInstance()->query("DELETE FROM [dbo].[merchant_codes] WHERE [id] = ".$idMcc));
    }

    public static function updateNameColumn($rowId, $table, $newName)
    {
        return Log::getLog()->info(Database::getInstance()->updateCellValue('[name]', $newName, '[id]', $rowId, $table));
    }
}