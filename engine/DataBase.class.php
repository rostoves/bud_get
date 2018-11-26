<?php
include '..\config\config.db.php';

class DataBase extends DB_config
{
    private static $db = null;
    private $conn;

    public static function getDB() {
        if (self::$db == null) self::$db = new DataBase();
        return self::$db;
    }

    private function __construct() {
        $this->conn = sqlsrv_connect($this->serverName, $this->connectionInfo);

        if($this->conn) {
           // echo "Connection established.<br />";
        } else {
            echo "Connection could not be established.<br />";
            die( print_r( sqlsrv_errors(), true));
        }
    }

    public function executeQuery($sql){
        $stmt = sqlsrv_query($this->conn, $sql);
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }
    }

    function getAssocQuery($sql){
        $stmt = sqlsrv_query($this->conn, $sql);
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }

        $array_result = array();
        while( $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC) ) {
            $array_result[] = $row;
        }
        return $array_result;
    }

    public function __destruct() {
        if ($this->conn) sqlsrv_close($this->conn);
    }
}