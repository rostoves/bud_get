<?php

class OperationList
{
    public static function getOperationsList()
    {
        return DataBase::getDB()->getAssocQuery('SELECT *  FROM [budget].[dbo].[operations_list]');
    }
}