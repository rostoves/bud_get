<?php
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

function switchAction($action) {
    switch($action) {
        case 'import/getMCC':
            $import = new Import;
            echo $import->getMccList();
            break;
        case 'import/postTable':
            $import = new Import;
            $import->insertOperationsTable($_POST['table']);
            break;
    }
}