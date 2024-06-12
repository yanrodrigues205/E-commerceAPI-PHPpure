<?php
    namespace factories;
    use services\ResponseService;

    class ControllerFactory
    {
        public function __construct()
        {

        }
        public static function callController(string $controller, string $method,string $request_type, $body_request, int $id_in_url)
        {
            $controller_name =  ucfirst(strtolower($controller)) . "Controller";
            $controller = "controllers\\".$controller_name;

            if(class_exists($controller))
            {
                if($id_in_url > 0)
                {
                    $body_request["id"] = $id_in_url;
                }

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