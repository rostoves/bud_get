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
        $res = $this->db->prepare($query);
        $res->execute($params);
        return $res;
    }

    public function exec($query, $params = null)
    {
        $stmt = $this->db->prepare($query);
        for ($i = 0; $i < count($params); $i++) {
            $stmt->bindParam($i + 1, $params[$i]);
        }
        $stmt->execute();
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

    public function getColumns($columns, $table)
    {
        return $this->select('SELECT '.$columns.' FROM [dbo].'.$table);
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