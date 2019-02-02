<?php
require_once '../libs/apache-log4php-2.3.0/Logger.php';

class Log
{
    public static function getLog()
    {
        Logger::configure(LOG_CONFIG);
        return Logger::getLogger('budgetLogger');
    }
}