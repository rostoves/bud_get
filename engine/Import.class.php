<?php

class Import
{
    public function getMccList()
    {
        $result = Database::getInstance()->getColumn('[name]', '[merchant_codes]');
        Log::getLog()->trace($result);
        return json_encode($result);
    }

    public static function insertOperationsTable($data) {
        Log::getLog()->trace("Get array for operations insert: ".print_r($data, 1));
        $mcc = Database::getInstance()->getColumn('[name]', '[merchant_codes]');
        $cur = Database::getInstance()->getColumn('[code]', '[currencies]');
        $desc = Database::getInstance()->getColumn('[description]', '[descriptions]');
        $cards = Database::getInstance()->getColumn('[number]', '[cards]');

        $mccCounter = self::mergeNewData($mcc, $data, 7, '[name]', '[merchant_codes]');
        $curCounter = self::mergeNewData($cur, $data, 4, '[code]', '[currencies]');
        $descCounter = self::mergeNewData($desc, $data, 8, '[description]', '[descriptions]');
        $cardsCounter = self::mergeNewData($cards, $data, 1, '[number]', '[cards]');
        $operationsCounter = '';
        $resultOperations['alreadyImportedOperations'] = [];
        $resultOperations['importedOperations'] = [];
        $resultOperations['notImportedOperations'] = [];

        foreach ($data as $row) {
            $params = "'".$row[0]."','".$row[8]."','".$row[5]."'";
            $check = Database::getInstance()->callScalarFunc('[check_operation_exist]',$params, 'id');
            if ($check[0]['id']) {
                array_push($resultOperations['alreadyImportedOperations'], $row[11]);
                Log::getLog()->warn("Operation ".$row[11]." was already imported with id: ".$check[0]['id']);
            } elseif (InsertOperations::callOperationsSP($row)) {
                array_push($resultOperations['importedOperations'], $row[11]);
                $operationsCounter++;
            } else {
                array_push($resultOperations['notImportedOperations'], $row[11]);
            }
        }

        Log::getLog()->trace("Results of import operations: ".print_r($resultOperations, 1));

        if ($mccCounter) Log::getLog()->info($mccCounter. " new MCC were inserted.");
        if ($curCounter) Log::getLog()->info($curCounter. " new currencies were inserted.");
        if ($descCounter) Log::getLog()->info($descCounter. " new descriptions were inserted.");
        if ($cardsCounter) Log::getLog()->info($cardsCounter. " new cards were inserted.");
        if ($operationsCounter) Log::getLog()->info($operationsCounter. " operation(s) were inserted.");

        return json_encode($resultOperations);
    }

    private static function mergeNewData($oldData, $newData, $index, $column, $table)
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