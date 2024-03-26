<?php
    namespace repositories;
    use database\MySql;

    class ProductRepository
    {
        private string $table = 'products';
        private object $database;

        public function __construct()
        {
            $this->database = new MySql();
        }

        /**
         * @return MySql|object
         */

        public function getDB() : object
        {
            return $this->database;
        }

    }