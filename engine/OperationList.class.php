<?php

class OperationList
{
    public static function getOperationsList()
    {
        $oplist =  Database::getInstance()->getColumns('*','[operations_list]');
        Log::getLog()->info("Returned operations list: " . count($oplist) . " rows");
        Log::getLog()->trace("Full operations list data: ". print_r($oplist,1));
        return $oplist;
    }
}