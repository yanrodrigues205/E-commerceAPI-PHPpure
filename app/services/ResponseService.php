<?php
    namespace services;

    class ResponseService
    {
        public static function send($message, $status) : string
        {
            $header = "";
            if($status == 200)
            {
                $header = "HTTP/1.1 200 OK";
            }
            else if($status == 400)
            {
                $header = "HTTP/1.1 400 Bad Request";
            }
            else if($status == 422)
            {
                $header = "HTTP/1.1 422 Unprocessable Entity";
            }
            else if($status == 404)
            {
                $header = "HTTP/1.1 404 Not Found";
            }
            else if($status == 405)
            {
                $header = "HTTP/1.0 405 Not Found";
            }
            else if($status == 500)
            {
                $header = "HTTP/1.1 500 Internal Server Error";
            }

            header($header);
            $message = [
                "message" => $message,
                "status" => $status
            ];
            echo json_encode($message);
            exit;
        }
    }
?>