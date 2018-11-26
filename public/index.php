<?php
require_once('../config/config.php');
require_once '../libs/Twig/Autoloader.php';
Twig_Autoloader::register();

$url_array = explode("/", $_SERVER['REQUEST_URI']);

$page_name = "index";
if($url_array[1] != "")
    $page_name = $url_array[1];

$action = "";
if($url_array[2] != "")
    $action = $url_array[2];

$variables = prepareVariables($page_name, $action);

try {
    $loader = new Twig_Loader_Filesystem('templates');

    $twig = new Twig_Environment($loader, array(
            'cache'       => 'compilation_cache',
            'auto_reload' => true)
    );


    echo $twig->render($page_name . '.html', $variables);

} catch (Exception $e) {
    die ('ERROR: ' . $e->getMessage());
}


