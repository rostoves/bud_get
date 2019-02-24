<?php
require_once '../config/config.php';
require_once '../libs/Twig/Autoloader.php';
Twig_Autoloader::register();

if(isset($_POST['action']) && !empty($_POST['action'])) {
    Log::getLog()->info("Get POST request: " . $_POST['action']);
    Variables::switchAction($_POST['action']);
} else {
    if (!empty($_GET['filter'])) {
        Log::getLog()->debug("Get GET request: " . print_r($_GET, 1));
    }

    $loader = new Twig_Loader_Filesystem('templates');
    $twig = new Twig_Environment($loader, array(
            'auto_reload' => true)
    );

    $page_name = Variables::definePageForRender($_SERVER['REQUEST_URI']);
    $variables = Variables::prepareVariables($page_name);

    Log::getLog()->info("Rendering page: " . $page_name);
    Log::getLog()->trace("Rendering page's variables: " . print_r($variables, 1));

    $page_html = $twig->render($page_name . '.html', $variables);

    Log::getLog()->info("Finished render page: " . $page_name);
    echo $page_html;
    return $page_html;
}










