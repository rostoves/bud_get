<?php

class InsertOperations
{
    public static function callOperationsSP($params)
    {
        Log::getLog()->trace("Inserting new operation: ".print_r($params, 1));
        $result = Database::getInstance()->executeSP('[source_data_import]', ':operation_date,:card,:status,:operation_sum,:operation_cur,:bargain_sum,:bargain_cur,:category,:description,:cashback,:comment,:rowId', $params);
        if ($result) {
            Log::getLog()->trace("Operation was successfully inserted. ID: ".$params[11]." Date: ".$params[0]." Sum: ".$params[5]." Category: ".$params[8]);
        } else {
            Log::getLog()->error("Operation wasn't inserted. ID: ".$params[11]." Date: ".$params[0]." Sum: ".$params[5]." Category: ".$params[8]);
        }
        return $result;
    }
}