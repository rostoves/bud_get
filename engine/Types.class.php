<?php

class Types
{

    public static function getTypesList()
    {
        $result = Database::getInstance()->getColumns('*','[operations_types]');
        Log::getLog()->trace($result);
        return $result;
    }

    public static function updateCatType($catId, $column, $newCatTypeId)
    {
        return Log::getLog()->info(Database::getInstance()->updateCellValue($column, $newCatTypeId, '[id]', $catId, '[operations_categories]'));
    }

    public static function deleteCat($idCat, $newCat)
    {
        Log::getLog()->info(Database::getInstance()->updateCellValue('[id_operations_categories]', $newCat, '[id_operations_categories]', $idCat, '[merchant_codes]'));
        Log::getLog()->info(Database::getInstance()->query("DELETE FROM [dbo].[operations_categories] WHERE [id] = ".$idCat));
    }

}