<?php
    namespace interfaces;
    interface JsonToFileInterface
    {
        public function saveJsonToFile(string $jsonData) : string ;
        public function convertJsonToCSV(string $jsonData) : string | false ;
    }
?>