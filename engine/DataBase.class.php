<?php

class Database extends PDO
{
    private static $_instance = null;

    private $db;

    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new Database();
        }
        return self::$_instance;
    }

    public function __construct() {
        $this->db = new PDO(PDO_DSN, PDO_USER, PDO_PASSWORD, PDO_OPTIONS);
    }

    public function query($query, $params = array())
    {
        Log::getLog()->trace('SQL query: '.$query);
        if ($params) Log::getLog()->trace('With parameters: '.print_r($params,1));
        $res = $this->db->prepare($query);
        $res->execute($params);
        return $res;
    }

    public function exec($query, $params = null)
    {
        Log::getLog()->trace('SQL query: '.$query);
        if ($params) Log::getLog()->trace('With parameters: '.print_r($params,1));
        $stmt = $this->db->prepare($query);
        for ($i = 0; $i < count($params); $i++) {
            $stmt->bindParam($i + 1, $params[$i]);
        }
        return $stmt->execute();
    }

    private function select($query, $params = array())
    {
        $result = $this->query($query, $params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    private function selectColumn($query, $params = array())
    {
        $result = $this->query($query, $params);
        $array = $result->fetchAll(PDO::FETCH_NUM);
        $column = [];
        foreach ($array as $v1) {
            foreach ($v1 as $v2) {
                array_push($column, $v2);
            }
        }

        return $column;
    }

    public function getColumn($column, $table)
    {
        return $this->selectColumn('SELECT '.$column.' FROM [dbo].'.$table);
    }

    public function getColumns($columns, $table, $order = '')
    {
        return $this->select('SELECT '.$columns.' FROM [dbo].'.$table.$order);
    }

    public function getColumnsWhereSingle($columns, $table, $where, $symbol, $condition, $order = '')
    {
        return $this->select("SELECT ".$columns." FROM [dbo].".$table." WHERE ".$where . $symbol." (".$condition.")".$order);
    }

    public function getColumnsWhereMultiple($columns, $table, $conditions, $order = '')
    {
        $counter = 0;
        $where = "";
        //the first item in the array $value had to be a symbol for WHERE operation
        foreach ($conditions as $key => $value) {
            if ($counter > 0) $where .= " AND ";

            $where .= $key . $value[0] ." (";

            for($i=1; $i< count($value); $i++) {
                switch ($i) {
                    case count($value) - 1:
                        $where .= $value[$i] . ")";
                        break;
                    default:
                        $where .= $value[$i] . ", ";
                        break;
                }
            }

            $counter++;
        }
        return $this->select('SELECT '.$columns.' FROM [dbo].'.$table.' WHERE '.$where . $order);
    }

    public function callScalarFunc($func, $params, $as = 'as')
    {
        return $this->select("SELECT [dbo].".$func." (".$params.") as ".$as);
    }

    public function addRow($value, $column, $table)
    {
        return $this->query("INSERT INTO [dbo].".$table." (".$column.") VALUES ('".$value."')");
    }

    public function updateCellValue ($columnUpdate, $columnUpdateValue, $columnCondition, $columnConditionValue, $table)
    {
        return $this->query("UPDATE [dbo].".$table." SET ".$columnUpdate." = ".$columnUpdateValue." WHERE ".$columnCondition." = ".$columnConditionValue);
    }

    public function executeSP($sp, $paramsNames, $params)
    {
        return $this->exec("EXECUTE [dbo].".$sp.$paramsNames, $params);
    }
}