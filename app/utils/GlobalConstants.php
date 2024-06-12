<?php
    namespace utils;
    abstract class GlobalConstants
    {
        /**
         * REQUEST CONSTANTS
         */
        public const REQUEST_TYPE = ['GET', 'POST', 'DELETE', 'PUT'];
        public const REQUEST_GET = ['USERS', 'PRODUCTS', 'SALES'];
        public const REQUEST_POST = ['USERS', 'PRODUCTS', 'SALES'];
        public const REQUEST_PUT = ['USERS', 'PRODUCTS', 'SALES']; //alt
        public const REQUEST_DELETE = ['USERS', 'PRODUCTS', 'SALES'];


        public const MESSAGE_INVALID_TYPE_REQUEST = "Check the type of request made (POST, GET, PUT, DELETE)";
    }
