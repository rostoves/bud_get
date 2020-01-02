<?php
define('SITE_ROOT', "../");
define('ENGINE_DIR', SITE_ROOT . 'engine/');

//database strings
define('PDO_DRIVER', 'sqlsrv:');
define('PDO_SERVER', 'Server=DESKTOP-PRQ9S2D\\SQLEXPRESS;');
define('PDO_DB', 'Database=budget');
define('PDO_DSN', PDO_DRIVER . PDO_SERVER . PDO_DB);
define('PDO_USER', 'sa');
define('PDO_PASSWORD', '123qweASD');
define('PDO_OPTIONS', array("CharacterSet" => "UTF-8", "ReturnDatesAsStrings" => 1));
define('LOG_CONFIG', SITE_ROOT . 'config/config_log4php.xml');

//site settings
define('DAYS_FOR_REGULARS_CALC', 180);
define('OP_NUMBER_SELECT', 200);
define('DESC_NUMBER_SELECT', 200);


//libs scanner
$lib_files = scandir(ENGINE_DIR);

foreach ($lib_files as $file){
    if($file != "." && $file != ".."){
        if(substr($file, -4) == ".php"){
            include_once (ENGINE_DIR . $file);

        }
    }
}