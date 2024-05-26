<?php
    namespace factories;
    use services\ResponseService;

    class ControllerFactory
    {
        public function __construct()
        {

        }
        public static function callController(string $controller, string $method,string $request_type, $body_request)
        {
            $controller_name =  $controller . "Controller";
            $controller = "controllers\\".$controller_name;

            if(class_exists($controller))
            {
                $obj = new $controller($body_request);
                if(method_exists($obj, $method))
                {
                    $call = $obj->$method($request_type);
                }
                else
                {
                    ResponseService::send(
                        "This route does not exist within the application!",
                        404
                    );

                }
            }
            else
            {
                ResponseService::send(
                    "This route does not exist within the application!",
                    404
                );
            }
        }
    }