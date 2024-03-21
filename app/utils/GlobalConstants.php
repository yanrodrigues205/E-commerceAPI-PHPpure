<?php
    namespace utils;
    abstract class GlobalConstants
    {
        /**
         * REQUEST CONSTANTS
         */
        public const REQUEST_TYPE = ['GET', 'POST', 'DELETE', 'PUT'];
        public const REQUEST_GET = ['USUARIOS'];
        public const REQUEST_POST = ['USUARIOS'];
        public const REQUEST_PUT = ['USUARIOS'];
        public const REQUEST_DELETE = ['USUARIOS'];

        /**
         * MESSAGES CONSTANTS
         */
        public const MSG_ROUTE_ERROR = 'The requested route was not found!';
    }
