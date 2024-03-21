<?php
/**
 * CLASSES A SEREM CARREGADAS
 * @param $class
 */

 function autoload($class)
 {
    $base_path = DIR_APP . DS;
    $class = $base_path . 'app' . DS . str_replace('\\', DS, $class) . '.php';
    if(file_exists(($class)) && !is_dir($class))
    {
        include_once($class);
    }

 }

 spl_autoload_register('autoload');