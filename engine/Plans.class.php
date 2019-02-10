<?php

class Plans
{
    public static function getPlansList()
    {
        $conditions = ['[status]' => ['=','\'PLAN\'']];
        $planslist =  Database::getInstance()->getColumnsWhereMultiple('TOP (1000) *','[operations_list]', $conditions,' ORDER BY [operation_date] DESC');
        Log::getLog()->info("Returned plans list: " . count($planslist) . " rows");
        Log::getLog()->trace("Full plans list data: ". print_r($planslist,1));
        return $planslist;
    }

    public static function updateRegularPlans()
    {
        $conditions = ['[type]' => ['=','\'Regular\''], '[operation_date]' => ['>', 'GetDATE() - 30']];
        $regulars =  Database::getInstance()->getColumnsWhereMultiple('[mcc], SUM([bargain_sum])/30 [bargain_sum]','[operations_list]', $conditions, 'GROUP BY [mcc]');
        Log::getLog()->TRACE("Got average sums for regular categories operations: " . print_r($regulars, 1));

        $dates = self::formDatesList(date('Y-m-j', strtotime("+1 day")), date('Y-m-j', strtotime("+1 year")));

        foreach ($dates as $date) {
            foreach ($regulars as $value) {
                $arr = [$date, '', 'PLAN', $value['bargain_sum'], 'RUB', $value['bargain_sum'], 'RUB', $value['mcc'], 'Плановый регулярный расход', 0, '', ''];
                InsertOperations::callOperationsSP($arr);
            }
        }
    }

    private static function formDatesList($_from, $_to)
    {
        $from = new DateTime($_from);
        $to   = new DateTime($_to);
        $period = new DatePeriod($from, new DateInterval('P1D'), $to);
        return array_map(
            function($item){return $item->format('d.m.Y');},
            iterator_to_array($period)
        );
    }
}

