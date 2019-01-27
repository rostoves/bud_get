<?php

class Categories
{
    public function getCategoriesList() {
        return json_encode(Database::getInstance()->select('SELECT *  FROM [budget].[dbo].[operations_categories]'));
    }

    public function getTypesList() {
        return json_encode(Database::getInstance()->select('SELECT * FROM [budget].[dbo].[operations_types]'));
    }

    public function getMccList() {
        return json_encode(Database::getInstance()->select('SELECT * FROM [budget].[dbo].[merchant_codes]'));
    }

    public function updateMccCat($mccId, $newMccCatId) {
        return _log(Database::getInstance()->updateCellValue('[id_operations_categories]', $newMccCatId, '[id]', $mccId, '[merchant_codes]'));
    }

    public function updateCatType($catId, $newCatTypeId) {
        return _log(Database::getInstance()->updateCellValue('[id_operations_types]', $newCatTypeId, '[id]', $catId, '[operations_categories]'));
    }
}