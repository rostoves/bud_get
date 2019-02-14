<?php

class OperationList
{
    public static function getOperationsList()
    {
        $conditions = ['[status]' => ['=','\'OK\'']];
        $oplist =  Database::getInstance()->getColumnsWhereMultiple('TOP (500) *','[operations_list]', $conditions,' ORDER BY [operation_date] DESC');
        Log::getLog()->info("Returned operations list: " . count($oplist) . " rows");
        Log::getLog()->trace("Full operations list data: ". print_r($oplist,1));
        return $oplist;
    }

    public static function getMccList()
    {
        $result = Database::getInstance()->getColumnsWhereSingle('[name]', '[merchant_codes]', '[id_operations_categories]', 'in', '(select [id] from [operations_categories] where [id_operations_types] not in (1))');
        Log::getLog()->trace($result);
        return $result;
    }

    public static function deleteOperation($id)
    {
        $result = Database::getInstance()->query("DELETE FROM [dbo].[operations] WHERE [id] = ".$id);
        Log::getLog()->debug($result);
        return $result;
    }
}