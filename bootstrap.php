<?php
/**
 * tratamento de erros para testes locais
 * @category ERRORS
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);
define('DATABASE_HOST', 'localhost');
define('DATABASE_NAME', 'fishing-ecommerce');
define('DATABASE_USER', 'root');
define('DATABASE_PASS', '');
define('DS', DIRECTORY_SEPARATOR);
define('DIR_APP', __DIR__);

if(file_exists('autoload.php'))
{
    include_once('autoload.php');
}
else
{
    new Error("file loading error 'autoload.php'!");
    exit;
}