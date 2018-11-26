<?php
define('SITE_ROOT', "../");
define('ENGINE_DIR', SITE_ROOT . 'engine/');

$lib_files = scandir(ENGINE_DIR);

foreach ($lib_files as $file){
    if($file != "." && $file != ".."){
        if(substr($file, -10) == ".class.php"){
            include_once (ENGINE_DIR . $file);
        }
    }
}

function prepareVariables($page_name, $action = "") {
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
        ]
    ];

    switch ($page_name) {
        case "index":
            break;
        case "oplist":
//            if($action == "") {
//
//            } else {
                $vars['op_list_table'] = OperationList::getOperationsList();
//            }
            break;
    }

    return $vars;
}
