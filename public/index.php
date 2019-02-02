<?php
require_once '../config/config.php';
require_once '../libs/Twig/Autoloader.php';
Twig_Autoloader::register();

if(isset($_POST['action']) && !empty($_POST['action'])) {
    Log::getLog()->info("Get POST request: " . $_POST['action']);
    switchAction($_POST['action']);
} else {
    $url_array = explode("/", $_SERVER['REQUEST_URI']);

    $page_name = "index";
    if($url_array[1] != "")
        $page_name = $url_array[1];

    $variables = prepareVariables($page_name);

    $loader = new Twig_Loader_Filesystem('templates');

    $twig = new Twig_Environment($loader, array(
            'auto_reload' => true)
    );

    Log::getLog()->info("Rendering page: " . $page_name);
    Log::getLog()->debug("Rendering page's variables: " . print_r($variables, 1));
    echo $twig->render($page_name . '.html', $variables);
}










