<?php
    namespace adapters;
    use interfaces\JsonToFileInterface;
    class JsonToFileAdapter implements JsonToFileInterface
    {
        private string $jsonFilePath;
        private string $csvFilePath;

        public function __construct(string $jsonFilePath, string $csvFilePath)
        {
            $this->jsonFilePath = $jsonFilePath;
            $this->csvFilePath = $csvFilePath;
        }

        public function saveJsonToFile(string $jsonData): string
        {
            $directory = dirname($this->jsonFilePath);
            if (!is_dir($directory)) {
                if (!mkdir($directory, 0777, true)) {
                    return false; // Retorna falso se o diretório não puder ser criado
                }
            }
    
            // Tenta salvar os dados JSON no arquivo
            $result = file_put_contents($this->jsonFilePath, $jsonData);
    
            if ($result === false) {
                return false; // Retorna falso se houver um erro ao escrever no arquivo
            }
    
            return $this->jsonFilePath;
        }

        public function convertJsonToCSV(string $jsonData): string | false
        {
            $dataArray = json_decode($jsonData, true);

            if(json_last_error() !== JSON_ERROR_NONE)
            {
                return false;
            }

            $directory = dirname($this->csvFilePath);
            if (!is_dir($directory)) {
                if (!mkdir($directory, 0777, true)) {

                    return false; // Retorna falso se o diretório não puder ser criado
                }
            }

            $csvFile = fopen($this->csvFilePath, "w");

            if(!$csvFile)
            {
                return false;
            }

            if(!empty($dataArray))
            {
                fputcsv($csvFile, array_keys($dataArray[0]));
            }

            foreach($dataArray as $row)
            {
                fputcsv($csvFile, $row);
            }

            fclose($csvFile);
            return $this->csvFilePath;
        }
    }
?>