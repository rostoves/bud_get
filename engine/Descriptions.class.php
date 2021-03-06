<?php

class Descriptions
{
    public static function getDescList($search = NULL)
    {
        if ($search != NULL) {
            Log::getLog()->info("Descriptions search string: " . $search);
            $result = Database::getInstance()->getColumnsWhereSingle('TOP ('.DESC_NUMBER_SELECT.') *', '[descriptions]', '[description]',' like', "'%".$search."%'",' ORDER BY [id_mcc_desc] DESC, [id] DESC, [description]');
        } else {
            $result = Database::getInstance()->getColumns('TOP ('.DESC_NUMBER_SELECT.') *', '[descriptions]', ' ORDER BY [id_mcc_desc] DESC, [id] DESC, [description]');
        }
        Log::getLog()->info("Returned descriptions list: " . count($result) . " rows");
        Log::getLog()->trace($result);
        return $result;
    }

    public static function updateDescMcc($descId, $column, $newDescMccId)
    {
        return Log::getLog()->info(Database::getInstance()->updateCellValue($column, $newDescMccId, '[id]', $descId, '[descriptions]'));
    }

    public static function deleteDesc($idDesc, $newDesc)
    {
        Log::getLog()->info(Database::getInstance()->updateCellValue('[id_description]', $newDesc, '[id_description]', $idDesc, '[operations]'));
        Log::getLog()->info(Database::getInstance()->query("DELETE FROM [dbo].[descriptions] WHERE [id] = ".$idDesc));
    }

    public static function updateDescColumn($rowId, $table, $newName)
    {
        return Log::getLog()->info(Database::getInstance()->updateCellValue('[description]', $newName, '[id]', $rowId, $table));
    }
}