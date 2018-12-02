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

    public static function insertOperationsTable($data) {
        $json = json_encode($data);
        $response = DataBase::getDB()->getAssocQuery('EXECUTE [dbo].[source_data_import] ' . $json);
        _log($response);
    }
}