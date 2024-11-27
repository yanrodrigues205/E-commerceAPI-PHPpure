<?php
    namespace strategy;
    use InvalidArgumentException;

    class QuickSortStrategy implements SortStrategy
    {
        public function sort(array $data, string $key): array
        {
            
            if (!empty($data) && !array_key_exists($key, $data[0])) {
                printf("A chave '{$key}' não existe nos itens do array.");
                return $data;
            }
    
           
            if (count($data) < 2) {
                return $data;
            }
    
            $pivot = $data[0];
            $pivotValue = $pivot[$key];
    
            $less = [];
            $greater = [];
    
            foreach (array_slice($data, 1) as $item) {
                if ($item[$key] <= $pivotValue) {
                    $less[] = $item;
                } else {
                    $greater[] = $item;
                }
            }
    
            return array_merge(
                $this->sort($less, $key),
                [$pivot],
                $this->sort($greater, $key)
            );
        }
    }