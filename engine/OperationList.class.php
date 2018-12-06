<?php

class OperationList
{
    public static function getOperationsList()
    {
        $oplist =  Database::getInstance()->select('SELECT *  FROM [budget].[dbo].[operations_list]');
        _log("Returned operations list: " . count($oplist) . " rows");
        return $oplist;
    }
}