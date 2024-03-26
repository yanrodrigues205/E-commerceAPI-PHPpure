<?php
    namespace utils;

    class Routes
    {
        /**
         * @return string[]
         */
        public static function getRoutes()
        {
            $urls = self::getUrls();
            $request = [];
            $request['route'] = strtoupper($urls[0]); // first 'directory' in route, SECTOR (users, sales, products)
            $request['resource'] =  strtoupper($urls[1]) ?? null;  // second 'directory' in route or null, OPERATION (create/delete/update/get)
            $request['id'] = $urls[2]; // third 'directory' in route or null, ID OPERATED
            // url: https://localhost/PROJECT_NAME/route/resource/id
            // exemple:  https://localhost/PROJECT_NAME/users/update/ajk591q40-ehwebw39-1jhbqr38
            $request['method'] = $_SERVER['REQUEST_METHOD']; // (get, post, put, delete)

            return $request;

        }

        /**
         * @return false|string[]
         */

        public static function getUrls()
        {
            $uri = str_replace('/' . DIR_PROJECT, '', $_SERVER['REQUEST_URI']); //TAKE / GET SELECTED ROUTE

            return explode("/", trim($uri, "/")); // SPLIT DIRECTORIES ROUTES
        }
    }
?>