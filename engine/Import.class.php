<?php

class Import
{
    public function getMccList()
    {
        return json_encode(Database::getInstance()->getColumn('[name]', '[merchant_codes]'));
    }

    public function insertOperationsTable($data) {
        Log::getLog()->trace("Get array for operations insert: ".print_r($data, 1));
        $mcc = Database::getInstance()->getColumn('[name]', '[merchant_codes]');
        $cur = Database::getInstance()->getColumn('[code]', '[currencies]');
        $desc = Database::getInstance()->getColumn('[description]', '[descriptions]');
        $cards = Database::getInstance()->getColumn('[number]', '[cards]');

        $this->mergeNewData($mcc, $data, 7, '[name]', '[merchant_codes]');
        $this->mergeNewData($cur, $data, 4, '[code]', '[currencies]');
        $this->mergeNewData($desc, $data, 8, '[description]', '[descriptions]');
        $this->mergeNewData($cards, $data, 1, '[number]', '[cards]');

        foreach ($data as $row) {
            Log::getLog()->trace("Inserting new operation: ".print_r($row, 1));
            $this->callOperationsSP($row);
        }

    }

    private function callOperationsSP($params)
    {
        Database::getInstance()->executeSP('[source_data_import]', ':operation_date,:card,:status,:operation_sum,:operation_cur,:bargain_sum,:bargain_cur,:category,:description,:cashback,:comment', $params);
    }

    private function mergeNewData($oldData, $newData, $index, $column, $table)
    {
        for ($i = 0; $i < count($newData); $i++) {
            if (in_array($newData[$i][$index], $oldData) == false) {
                array_push($oldData, $newData[$i][$index]);
                Log::getLog()->info(Database::getInstance()->addRow($newData[$i][$index], $column, $table));
            }
        }
    }
}