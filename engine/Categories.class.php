<?php

class Categories
{
    public function getCategoriesList()
    {
        $result = Database::getInstance()->getColumns('*','[operations_categories]');
        Log::getLog()->trace($result);
        return json_encode($result);
    }

    public function getTypesList()
    {
        $result = Database::getInstance()->getColumns('*','[operations_types]');
        Log::getLog()->trace($result);
        return json_encode($result);
    }

    public function getMccList()
    {
        $result = Database::getInstance()->getColumns('*', '[merchant_codes]');
        Log::getLog()->trace($result);
        return json_encode($result);
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