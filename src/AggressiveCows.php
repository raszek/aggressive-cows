<?php

namespace App;

use Exception;

function dd($var)
{
    var_dump($var);
    die;
}

function dump($var)
{
    var_dump($var);
}

readonly class AggressiveCows
{

    const int MAX_STALL_NUMBER = 100_000;

    public function __construct(
        private int $cowNumber,
    ) {
    }

    public function calculateMinimumDistance(array $stallLocations): int
    {
        if (count($stallLocations) > self::MAX_STALL_NUMBER) {
            throw new Exception(sprintf('It cannot be more than %d stall locations.', self::MAX_STALL_NUMBER));
        }

        if ($this->cowNumber < 2) {
            throw new Exception('Cow number must be at least 2 cows.');
        }

        sort($stallLocations);

        $cowInStallIndexes = [];
        for ($i = 0; $i < $this->cowNumber; $i++) {
            $cowInStallIndexes = $this->addCow($cowInStallIndexes, $stallLocations);

            sort($cowInStallIndexes);
        }

        $values = [];
        foreach ($cowInStallIndexes as $cowInStallIndex) {
            $values[] = $stallLocations[$cowInStallIndex];
        }

        return $this->minimumDistance($values);
    }

    private function addCow(array $cowInStallIndexes, array $stallLocations): array
    {
        if (count($cowInStallIndexes) <= 0) {
            return [0];
        }

        if (count($cowInStallIndexes) === 1) {
            $cowInStallIndexes[] = count($stallLocations) - 1;

            return $cowInStallIndexes;
        }

        $results = [];
        for ($i = 0; $i < count($cowInStallIndexes) - 1; $i++) {
            $results[] = $this->findLargestDistanceBetweenCows($cowInStallIndexes[$i], $cowInStallIndexes[$i + 1], $stallLocations);
        }
        
        $smallestDistance = min(array_column(array_filter($results, fn($record) => !in_array($record['position'], $cowInStallIndexes)), 'distance'));

        foreach ($results as $result) {
            if ($result['distance'] === $smallestDistance && !in_array($result['position'], $cowInStallIndexes)) {
                return array_merge($cowInStallIndexes, [$result['position']]);
            }
        }

        throw new \Exception('Empty results problem');
    }

    private function findLargestDistanceBetweenCows($leftCowPosition, $rightCowPosition, $stallLocations): array
    {
        $result = [];
        
        for ($i = $leftCowPosition + 1; $i < count($stallLocations) - 1; $i++) {
            $distanceFromLeftCow = $stallLocations[$i] - $stallLocations[$leftCowPosition];
            $distanceFromRightCow = $stallLocations[$rightCowPosition] - $stallLocations[$i];
            
            $result[] = [
                'position' => $i,
                'distance' => abs($distanceFromRightCow - $distanceFromLeftCow),
            ];
        }
        
        $lowestDistance = min(array_column($result, 'distance'));

        foreach ($result as $value) {
            if ($value['distance'] === $lowestDistance) {
                return $value;
            }
        }

        throw new \Exception('Minimal distance not found');
    }

    private function minimumDistance(array $cowInStalls): int
    {
        $distances = [];
        for ($i = 0; $i < count($cowInStalls) - 1; $i++) {
            $distances[] = $cowInStalls[$i + 1] - $cowInStalls[$i];
        }
        
        return min($distances);
    }

}
