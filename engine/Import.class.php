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

        $mccCounter = $this->mergeNewData($mcc, $data, 7, '[name]', '[merchant_codes]');
        $curCounter = $this->mergeNewData($cur, $data, 4, '[code]', '[currencies]');
        $descCounter = $this->mergeNewData($desc, $data, 8, '[description]', '[descriptions]');
        $cardsCounter = $this->mergeNewData($cards, $data, 1, '[number]', '[cards]');
        $operationsCounter = '';

        foreach ($data as $row) {
            $params = "'".$row[0]."','".$row[7]."','".$row[5]."'";
            $check = Database::getInstance()->callScalarFunc('[check_operation_exist]',$params, 'id');
            if ($check[0]['id']) {
                Log::getLog()->warn("Operation was already imported with id: ".$check[0]['id']);
            } elseif ($this->callOperationsSP($row)) {
                $operationsCounter++;
            }
        }

        if ($mccCounter) Log::getLog()->info($mccCounter. " new MCC were inserted.");
        if ($curCounter) Log::getLog()->info($curCounter. " new currencies were inserted.");
        if ($descCounter) Log::getLog()->info($descCounter. " new descriptions were inserted.");
        if ($cardsCounter) Log::getLog()->info($cardsCounter. " new cards were inserted.");
        if ($operationsCounter) Log::getLog()->info($operationsCounter. " operation(s) were inserted.");

    }

    private function callOperationsSP($params)
    {
        Log::getLog()->trace("Inserting new operation: ".print_r($params, 1));
        $result = Database::getInstance()->executeSP('[source_data_import]', ':operation_date,:card,:status,:operation_sum,:operation_cur,:bargain_sum,:bargain_cur,:category,:description,:cashback,:comment', $params);
        if ($result) {
            Log::getLog()->trace("Operation was successfully inserted. Date: ".$params[0]." Sum: ".$params[5]." Category: ".$params[8]);
        } else {
            Log::getLog()->error("Operation wasn't inserted. Date: ".$params[0]." Sum: ".$params[5]." Category: ".$params[8]);
        }
        return $result;
    }

    private function mergeNewData($oldData, $newData, $index, $column, $table)
    {
        $counter = '';
        for ($i = 0; $i < count($newData); $i++) {
            if (in_array($newData[$i][$index], $oldData) == false) {
                array_push($oldData, $newData[$i][$index]);
                Log::getLog()->debug("Inserting new ".$table.$column.": ".$newData[$i][$index]);
                $result = Database::getInstance()->addRow($newData[$i][$index], $column, $table);
                if ($result) {
                    Log::getLog()->debug("New ".$table.$column." was successfully inserted: ".$newData[$i][$index]);
                    $counter++;
                } else {
                    Log::getLog()->error("New ".$table.$column." wasn't inserted: ".$newData[$i][$index]);
                }
            }
        }
        return $counter;
    }
}