<?php
define('SITE_ROOT', "../");
define('ENGINE_DIR', SITE_ROOT . 'engine/');

$lib_files = scandir(ENGINE_DIR);

foreach ($lib_files as $file){
    if($file != "." && $file != ".."){
        if(substr($file, -4) == ".php"){
            include_once (ENGINE_DIR . $file);
        }
    }
}

function prepareVariables($page_name) {
    $vars = [
        "main_menu_links" => [
            [
                "href" => "/",
                "link_title" => "Main"
            ],
            [
                "href" => "/oplist/",
                "link_title" => "Operations List"
            ]
            ,
            [
                "href" => "/import/",
                "link_title" => "Import"
            ]
        ]
    ];

    switch ($page_name) {
        case "index":
            break;
        case "oplist":
            $vars['op_list_table'] = OperationList::getOperationsList();
            break;
        case "import":
            break;
    }

    return $vars;
}

class DB_config
{
    protected $serverName = "DESKTOP-PRQ9S2D\\SQLEXPRESS";
    protected $connectionInfo = array( "Database"=>"budget",
        "UID"=>"sa",
        "PWD"=>"123qweASD",
        "CharacterSet" => "UTF-8",
        "ReturnDatesAsStrings" => 1);

}