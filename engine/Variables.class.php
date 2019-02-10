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
                    "href" => "/plans/",
                    "link_title" => "Plans"
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
                $vars['op_list_table'] = OperationList::getOperationsList();
                break;
            case "plans":
                $vars['op_list_table'] = Plans::getPlansList();
                break;
            case "import":
                break;
            case "categories":
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
                $import = new Import;
                $json = $import->insertOperationsTable($_POST['table']);
                Log::getLog()->trace("Sended JSON: ".$json);
                echo $json;
                break;
            case 'categories/getTypes':
                $cats = new Categories;
                echo $cats->getTypesList();
                break;
            case 'categories/getCats':
                $cats = new Categories;
                echo $cats->getCategoriesList();
                break;
            case 'categories/getMCC':
                $cats = new Categories;
                echo $cats->getMccList();
                break;
            case 'categories/updateMccCat':
                $cats = new Categories;
                $cats->updateMccCat($_POST['mccId'], $_POST['newMccCatId']);
                break;
            case 'categories/updateCatType':
                $cats = new Categories;
                $cats->updateCatType($_POST['catId'], $_POST['newCatTypeId']);
                break;
            case 'plans/updateRegulars':
                Plans::updateRegularPlans();
                break;
        }
    }
}
