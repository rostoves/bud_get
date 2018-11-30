<?php
require_once('../config/config.php');
require_once '../libs/Twig/Autoloader.php';
Twig_Autoloader::register();

if(isset($_POST['action']) && !empty($_POST['action'])) {
    _log("POST: ");
    _log($_POST);
    $_action = $_POST['action'];
    switch($_action) {
        case 'import/getMCC':
            echo Import::getMccList();
            break;
    }
} else {
    $url_array = explode("/", $_SERVER['REQUEST_URI']);

    $page_name = "index";
    if($url_array[1] != "")
        $page_name = $url_array[1];

    $action = "";
    if($url_array[2] != "")
        $action = $url_array[2];

    $variables = prepareVariables($page_name);

    $loader = new Twig_Loader_Filesystem('templates');

    $twig = new Twig_Environment($loader, array(
            'cache'       => 'compilation_cache',
            'auto_reload' => true)
    );

    _log("Render: " . $page_name . ". Variables: ");
//    _log($variables);
    echo $twig->render($page_name . '.html', $variables);
}










