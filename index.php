<?php

    use utils\Routes;
    use validation\Request;
    include_once("bootstrap.php");

    try
    {
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Origin: *");
        $request_validation = new Request(Routes::getRoutes());
        $process = $request_validation->processRequest();
    }
    catch (\Exception $e)
    {
        $err = new Error("Error when sending routes to the request validator! Error => ".$e);
    }
?>
