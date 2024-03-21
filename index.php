<?php

    use utils\Routes;
    use validation\Request;
    include_once("bootstrap.php");

    try
    {
        $request_validation = new Request(Routes::getRoutes());
        $process = $request_validation->processRequest();
    }
    catch (\Exception $e)
    {
        $err = new Error("Error when sending routes to the request validator! Error => ".$e);
    }
?>
