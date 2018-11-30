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

/**
 * Логирование
 * @param $s
 * @param string $suffix
 * @return mixed|string
 */
function _log($s, $suffix='')
{
    if (is_array($s) || is_object($s)) $s = print_r($s, 1);
    $s="### ".date("d.m.Y H:i:s")." ".$s."\r\n";

    if (mb_strlen($suffix))
        $suffix = "_".$suffix;

    _writeToFile($_SERVER['DOCUMENT_ROOT']."/_log/logs".$suffix.".log",$s,"a+");


    return $s;
}

/**
 * Запись в файл
 * @param $fileName
 * @param $content
 * @param string $mode
 * @return bool
 */
function _writeToFile($fileName, $content, $mode="w")
{
    $dir=mb_substr($fileName,0,strrpos($fileName,"/"));
    if (!is_dir($dir))
    {
        _makeDir($dir);
    }

    if($mode != "r")
    {
        $fh=fopen($fileName, $mode);
        if (fwrite($fh, $content))
        {
            fclose($fh);
            @chmod($fileName, 0644);
            return true;
        }
    }

    return false;
}

/**
 * Создание директории
 * @param $dir
 * @param bool $is_root
 * @param string $root
 * @return bool|string
 */
function _makeDir($dir, $is_root = true, $root = '')
{
    $dir = rtrim($dir, "/");
    if (is_dir($dir)) return true;
    if (mb_strlen($dir) <= mb_strlen($_SERVER['DOCUMENT_ROOT']))
        return true;
    if (str_replace($_SERVER['DOCUMENT_ROOT'], "", $dir) == $dir)
        return true;

    if ($is_root)
    {
        $dir = str_replace($_SERVER['DOCUMENT_ROOT'], '', $dir);
        $root = $_SERVER['DOCUMENT_ROOT'];
    }
    $dir_parts = explode("/", $dir);

    foreach ($dir_parts as $step => $value)
    {
        if ($value != '')
        {
            $root = $root . "/" . $value;
            if (!is_dir($root))
            {
                mkdir($root, 0755);
                chmod($root, 0755);
            }
        }
    }
    return $root;
}