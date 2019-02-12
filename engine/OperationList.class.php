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
}