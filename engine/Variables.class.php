<?php

class Variables {
    public static function definePageForRender($uri)
    {
        $url_array = explode("/", $uri);

        $page_name = "index";
        if($url_array[1] != "") $page_name = $url_array[1];

        return $page_name;
    }

    public static function prepareVariables($page_name)
    {
        $vars = [
            "main_menu_links" => [
                [
                    "href" => "/",
                    "link_title" => "Main"
                ],
                [
                    "href" => "/oplist/",
                    "link_title" => "Operations List"
                ],
                [
                    "href" => "/import/",
                    "link_title" => "Import"
                ],
                [
                    "href" => "/categories/",
                    "link_title" => "Categories"
                ]
            ]
        ];

        switch ($page_name) {
            case "index":
                break;
            case "oplist":
            case "op_list_table":
                $vars['op_list_table'] = OperationList::getOperationsList($_GET['filter'], $_GET['order']);
                $vars['mcc_list'] = OperationList::getMccList();
                $vars['cards_list'] = OperationList::getCardList();
                $vars['cats_list'] = OperationList::getCatsList();
                $vars['types_list'] = OperationList::getTypesList();
                break;
            case "import":
                break;
            case "categories":
                $vars['types_list'] = Categories::getTypesList();
                $vars['mcc_list'] = Categories::getMccList();
                $vars['cats_list'] = Categories::getCategoriesList();
                $vars['desc_list'] = Categories::getDescList();
                break;
        }

        return $vars;
    }

    public static function switchAction($action)
    {
        Log::getLog()->debug("Processing POST request: ".$action);
        switch($action) {
            case 'import/getMCC':
                $import = new Import;
                echo $import->getMccList();
                break;
            case 'import/importTable':
                $json = Import::insertOperationsTable($_POST['data']);
                Log::getLog()->trace("Sended JSON: ".$json);
                echo $json;
                Plans::updateRegularPlans();
                break;
            case 'categories/updateMccCat':
                Categories::updateMccCat($_POST['rowId'], $_POST['field'], $_POST['newValue']);
                break;
            case 'categories/updateCatType':
                Categories::updateCatType($_POST['rowId'], $_POST['field'], $_POST['newValue']);
                break;
            case 'categories/deleteMcc':
                Categories::deleteMcc($_POST['rowId'], $_POST['newValue']);
                break;
            case 'categories/deleteCat':
                Categories::deleteCat($_POST['rowId'], $_POST['newValue']);
                break;
            case 'categories/deleteDesc':
                Categories::deleteDesc($_POST['rowId'], $_POST['newValue']);
                break;
            case 'categories/updateNameColumn':
                Categories::updateNameColumn($_POST['rowId'], $_POST['field'], $_POST['newValue']);
                break;
            case 'op_list_table/addOperation':
                Import::insertOperationsTable($_POST['data']);
                break;
            case 'op_list_table/deleteOperation':
                OperationList::deleteOperation($_POST['data']);
                break;
            case 'op_list_table/updateOperation':
                OperationList::updateOperationColumn($_POST['rowId'], $_POST['field'], $_POST['newValue']);
                break;
//            case 'op_list_table/updateOperationDesc':
//                OperationList::updateOperationColumn($_POST['rowId'], '[id_description]', $_POST['newValue']);
//                break;
            case 'op_list_table/getDescList':
                echo OperationList::getDescList();
                break;
        }
    }
}
