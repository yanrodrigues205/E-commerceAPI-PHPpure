<?php
    namespace strategy;

    class BubbleSortStrategy implements SortStrategy
    {
        public function sort(array $data, string $key): array
        {
            $size = count($data);
            for ($i = 0; $i < $size - 1; $i++) {
                for ($y = 0; $y < $size - $i - 1; $y++) {
                    if ($data[$y][$key] > $data[$y + 1][$key]) {
                        $temp = $data[$y];
                        $data[$y] = $data[$y + 1];
                        $data[$y + 1] = $temp;
                    }
                }
            }
    
            return $data;
        }
    }