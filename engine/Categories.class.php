<?php

class Categories
{
    public function getCategoriesList()
    {
        return json_encode(Database::getInstance()->getColumns('*','[operations_categories]'));
    }

    public function getTypesList()
    {
        return json_encode(Database::getInstance()->getColumns('*','[operations_types]'));
    }

    public function getMccList()
    {
        return json_encode(Database::getInstance()->getColumns('*', '[merchant_codes]'));
    }

    public function updateMccCat($mccId, $newMccCatId)
    {
        return Log::getLog()->info(Database::getInstance()->updateCellValue('[id_operations_categories]', $newMccCatId, '[id]', $mccId, '[merchant_codes]'));
    }

    public function updateCatType($catId, $newCatTypeId)
    {
        return Log::getLog()->info(Database::getInstance()->updateCellValue('[id_operations_types]', $newCatTypeId, '[id]', $catId, '[operations_categories]'));
    }
}