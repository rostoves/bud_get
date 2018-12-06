<?php

class Import
{
    public function getMccList()
    {
        return json_encode($this->getColumn('[name]', '[merchant_codes]'));
    }

    public function insertOperationsTable($data) {
        $data = [
                ["02.12.2018 14:01:50","*0816","OK","-411,00","RUB","-411,00","RUB","Красота","Yves Rocher","0,00",""],
                ["02.12.2018 13:59:56","*0816","OK","-427,00","RUB","-427,00","RUB","Красота","Yves Rocher","0,00",""],
                ["02.12.2018 02:49:13","*3629","OK","-36,65","EUR","-2833,04","RUB","Отели","TALLINK EXPRESS HOTELL","0,00",""]
                ];
//        _log($data);
        $mcc = $this->getColumn('[name]', '[merchant_codes]');
        $cur = $this->getColumn('[code]', '[currencies]');
        $desc = $this->getColumn('[description]', '[descriptions]');
        $cards = $this->getColumn('[number]', '[cards]');
//        _log(print_r($cur, 1));

        $this->mergeNewData($mcc, $data, 7, '[name]', '[merchant_codes]');
        $this->mergeNewData($cur, $data, 4, '[code]', '[currencies]');
        $this->mergeNewData($desc, $data, 8, '[description]', '[descriptions]');
        $this->mergeNewData($cards, $data, 1, '[number]', '[cards]');

        foreach ($data as $row) {
            $this->callOperationsSP($row);
        }

    }

    private function callOperationsSP($params)
    {
        return Database::getInstance()->exec("EXECUTE [dbo].[source_data_import] 
            :operation_date,:card,:status,:operation_sum,:operation_cur,:bargain_sum,:bargain_cur,:category,:description,:cashback,:comment"
            , $params);
    }

    private function mergeNewData($oldData, $newData, $index, $column, $table)
    {
        for ($i = 0; $i < count($newData); $i++) {
            if (in_array($newData[$i][$index], $oldData) == false) {
                array_push($oldData, $newData[$i][$index]);
                _log($this->addRow($newData[$i][$index], $column, $table));
            }
        }
    }

    private function getColumn($column, $table)
    {
        return DataBase::getInstance()->selectColumn('SELECT '.$column.' FROM [budget].[dbo].'.$table);
    }

    private function addRow($value, $column, $table)
    {
        return Database::getInstance()->query("INSERT INTO [dbo].".$table." (".$column.") VALUES ('".$value."')");
    }
}