<?php

class OperationList
{
    public static function getOperationsList($filter = NULL, $_order = NULL)
    {
        if ($filter != NULL) {
            $conditions = $filter;
            $order = ' ORDER BY [operation_date] ' . $_order;
        } else {
            $conditions['status'] = [' =','\'OK\''];
            $order = ' ORDER BY [operation_date] DESC';
        }
        $oplist =  Database::getInstance()->getColumnsWhereMultiple('TOP ('.OP_NUMBER_SELECT.') *','[operations_list]', $conditions, $order);
        Log::getLog()->info("Returned operations list: " . count($oplist) . " rows");
        Log::getLog()->trace("Full operations list data: ". print_r($oplist,1));
        return $oplist;
    }

    public static function getMccList()
    {
        $result = Database::getInstance()->getColumnsWhereSingle('[id], [name]', '[merchant_codes]', '[id_operations_categories]', 'in', '(select [id] from [operations_categories] where [id_operations_types] not in (1))');
        Log::getLog()->trace($result);
        return $result;
    }

    public static function getCardList()
    {
        $result = Database::getInstance()->getColumns('[id], [number], [name], [owner], [bank]', '[cards]');
        Log::getLog()->trace($result);
        return $result;
    }

    public static function getCatsList()
    {
        $result = Database::getInstance()->getColumn('[name]', '[operations_categories]');
        Log::getLog()->trace($result);
        return $result;
    }

    public static function getTypesList()
    {
        $result = Database::getInstance()->getColumn('[name]', '[operations_types]');
        Log::getLog()->trace($result);
        return $result;
    }

    public static function deleteOperation($id)
    {
        $result = Database::getInstance()->query("DELETE FROM [dbo].[operations] WHERE [id] = ".$id);
        Log::getLog()->debug($result);
        return $result;
    }

    public static function updateOperationColumn($operationId, $column, $newValue)
    {
        if ($newValue == NULL) $newValue = '\'\'';
        return Log::getLog()->info(Database::getInstance()->updateCellValue($column, $newValue, '[id]', $operationId, '[operations]'));
    }
}