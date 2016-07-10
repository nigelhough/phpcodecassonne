<?php

namespace Codecassonne\Scoring;

use Codecassonne\Map\Map;
use Codecassonne\Map\Coordinate;

class Service
{
    /**
     * Score a Coordinate on a Map
     *
     * @param Map        $map               Map to score coordinate on
     * @param Coordinate $scoringCoordinate Coordinate to score
     *
     * @return int
     */
    public function calculateScore(Map $map, Coordinate $scoringCoordinate)
    {
        return 4;
    }
}
