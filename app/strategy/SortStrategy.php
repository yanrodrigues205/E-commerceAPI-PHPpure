<?php 
    namespace strategy;

    interface SortStrategy
    {
        public function sort(array $data, string $key): array;
    }