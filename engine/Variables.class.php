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
                ],
                [
                    "href" => "/types/",
                    "link_title" => "Types"
                ],
                [
                    "href" => "/descriptions/",
                    "link_title" => "Descriptions"
                ]
            ]
        ];
        Log::getLog()->trace("Processing page name: ".$page_name);
        switch ($page_name) {
            case "index":
                break;
            case "oplist":
            case "op_list_table":
                $vars['op_list_table'] = OperationList::getOperationsList($_GET['filter'], $_GET['order']);
                $vars['mcc_list'] = OperationList::getMccList();
               // $vars['cards_list'] = OperationList::getCardList();
                $vars['cats_list'] = OperationList::getCatsList();
                $vars['types_list'] = OperationList::getTypesList();
                break;
            case "import":
                $vars['mcc_list'] = OperationList::getMccList();
                $vars['cards_list'] = OperationList::getCardList();
                break;
            case "categories":
                $vars['mcc_list'] = Categories::getMccList();
                $vars['cats_list'] = Categories::getCategoriesList();
                break;
            case "types":
                $vars['types_list'] = Types::getTypesList();
                $vars['cats_list'] = Categories::getCategoriesList();
                break;
            case "descriptions":
            case "descriptions_table":
                $vars['mcc_list'] = Categories::getMccList();
                $vars['desc_list'] = Descriptions::getDescList($_GET['search']);
                break;
        }

        return $vars;
    }

    public static function switchAction($action)
    {
        Log::getLog()->debug("Processing POST request: ".$action);
        switch($action) {
            case 'import/getMCC':
                echo json_encode(Import::getMccList());
                break;
            case 'import/getDesc':
                echo json_encode(Import::getDescList());
                break;
            case 'import/getFullDescList':
                echo json_encode(Import::getFullDescList());
                break;
            case 'import/importTable':
                $json = json_encode(Import::insertOperationsTable($_POST['data']));
                Log::getLog()->trace("Sended JSON: ".$json);
                echo $json;
                Plans::updateRegularPlans();
                break;
            case 'import/checkOutdatedPlans':
                $response = json_encode(OperationList::getOperationsList($_POST['filter']));
                Log::getLog()->info("Result of checkOutdatedPlans: ". $response);
                echo $response;
                break;
            case 'import/addOperation':
                Import::insertOperationsTable($_POST['data']);
                break;
            case 'categories/updateMccCat':
                Categories::updateMccCat($_POST['rowId'], $_POST['field'], $_POST['newValue']);
                break;
            case 'categories/deleteMcc':
                Categories::deleteMcc($_POST['rowId'], $_POST['newValue']);
                break;
            case 'categories/updateNameColumn':
                Categories::updateNameColumn($_POST['rowId'], $_POST['field'], $_POST['newValue']);
                break;
            case 'types/updateCatType':
                Types::updateCatType($_POST['rowId'], $_POST['field'], $_POST['newValue']);
                break;
            case 'types/deleteCat':
                Types::deleteCat($_POST['rowId'], $_POST['newValue']);
                break;
            case 'descriptions/updateDescMcc':
                Descriptions::updateDescMcc($_POST['rowId'], $_POST['field'], $_POST['newValue']);
                break;
            case 'descriptions/deleteDesc':
                Descriptions::deleteDesc($_POST['rowId'], $_POST['newValue']);
                break;
            case 'descriptions/updateDescColumn':
                Descriptions::updateDescColumn($_POST['rowId'], $_POST['field'], $_POST['newValue']);
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
//            case 'op_list_table/getDescList':
//                echo json_encode(OperationList::getDescList());
//                break;
        }
    }
}
