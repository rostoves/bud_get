<?php

class Plans
{
    public static function updateRegularPlans()
    {
        Database::getInstance()->query("DELETE FROM [dbo].[operations] WHERE [id_description] = (2998) AND [operation_date] < ('".date('Y-m-j', strtotime("+1 day"))."')");

        $conditions_reg = ['[type]' => ['=','\'Regular\''], '[operation_date]' => ['>', 'GetDATE() - '.DAYS_FOR_REGULARS_CALC], '[description]' => ['!=', '\'Плановый регулярный расход\'']];
        $regulars =  Database::getInstance()->getColumnsWhereMultiple('[mcc], SUM([bargain_sum])/'.DAYS_FOR_REGULARS_CALC.' [bargain_sum]','[operations_list]', $conditions_reg, 'GROUP BY [mcc]');
        Log::getLog()->info("Got average sums for regular categories operations: " . print_r($regulars, 1));

        foreach ($regulars as $mcc) {
            Database::getInstance()->query("UPDATE [dbo].[operations_list] SET [bargain_sum] = ".$mcc['bargain_sum']." WHERE [description] = ('Плановый регулярный расход') AND [mcc] = '".$mcc['mcc']."' AND [operation_date] >= ('".date('Y-m-j')."')");
        }

        $lastplandate = Database::getInstance()->getColumnsWhereSingle('TOP (1) [operation_date]', '[operations_list]', '[description]', '=', '\'Плановый регулярный расход\'', ' ORDER BY [operation_date] DESC');
        Log::getLog()->debug("Latest date with planned operations: ".$lastplandate[0]['operation_date']);
        $dates = self::formDatesList(date('Y-m-j', strtotime($lastplandate[0]['operation_date']."+1 day")), date('Y-m-j', strtotime("+1 year")));
        Log::getLog()->debug("New period for planning: : ".print_r($dates,1));

        foreach ($dates as $date) {
            foreach ($regulars as $value) {
                $arr = [$date, '', 'PLAN', $value['bargain_sum'], 'RUB', $value['bargain_sum'], 'RUB', $value['mcc'], 'Плановый регулярный расход', 0, '', ''];
                InsertOperations::callOperationsSP($arr);
            }
        }
    }

    private static function formDatesList($from, $to)
    {
        $period = new DatePeriod(new DateTime($from), new DateInterval('P1D'), new DateTime($to));
        return array_map(
            function($item){return $item->format('d.m.Y');},
            iterator_to_array($period)
        );
    }
}

