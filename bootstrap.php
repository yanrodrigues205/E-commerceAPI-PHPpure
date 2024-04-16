<?php
/**
 * tratamento de erros para testes locais
 * @category ERRORS
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);
define('DATABASE_HOST', 'localhost'); //docker = database, local = localhost
define('DATABASE_NAME', 'fishing-ecommerce');
define('DATABASE_USER', 'root');
define('DATABASE_PASS', ''); //root = '', docker = 2b2232df-eb16-432f-a9f7-1242f3fa54b4
define('DS', DIRECTORY_SEPARATOR);
define('DIR_APP', __DIR__);
define('DIR_PROJECT', 'E-commerceAPI-PHPpure');

if(file_exists('autoload.php'))
{
    include_once('autoload.php');
}
else
{
    new Error("file loading error 'autoload.php'!");
    exit;
}