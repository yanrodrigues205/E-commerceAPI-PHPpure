<?php
    namespace utils;
    abstract class GlobalConstants
    {
        /**
         * REQUEST CONSTANTS
         */
        public const REQUEST_TYPE = ['GET', 'POST', 'DELETE', 'PUT'];
        public const REQUEST_GET = ['USERS', 'PRODUCTS'];
        public const REQUEST_POST = ['USERS', 'PRODUCTS'];
        public const REQUEST_PUT = ['USERS', 'PRODUCTS']; //alt
        public const REQUEST_DELETE = ['USERS', 'PRODUCTS'];

        /**
         * MESSAGES CONSTANTS
         */
        public const MSG_ROUTE_ERROR = 'The requested route was not found!';
    }
