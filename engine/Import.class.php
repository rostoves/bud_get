<?php

class Import
{
    public static function getMccList()
    {
        $mcc = DataBase::getDB()->getAssocQuery('SELECT [name] FROM [budget].[dbo].[merchant_codes]');
        $mcc = json_encode($mcc);
        _log("Import MCC response: " . $mcc);
        return $mcc;
    }
}