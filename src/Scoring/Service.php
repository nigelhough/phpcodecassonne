<?php
declare(strict_types = 1);

namespace Codecassonne\Scoring;

use Codecassonne\Feature\Factory;
use Codecassonne\Map\Map;
use Codecassonne\Map\Coordinate;

/**
 * Service to score a game of Codecassonne
 */
class Service
{
    /**
     * Score a Coordinate on a Map
     *
     * @param Map        $map               Map to score coordinate on
     * @param Coordinate $scoringCoordinate Coordinate to score
     *
     * @return int Points scored for coordinate
     * @throws Exception\ScoringInvalidCoordinate
     */
    public function calculateScore(Map $map, Coordinate $scoringCoordinate)
    {
        if (!$map->isOccupied($scoringCoordinate)) {
            throw new Exception\ScoringInvalidCoordinate('Can\'t score a coordinate that isn\'t occupied');
        }
        $score = 0;

        // Score Features (currently not including cloisters)
        $featureFactory = new Factory();
        $features = $featureFactory->createFeatures($scoringCoordinate, $map);
        foreach ($features as $feature) {
            if ($feature->isComplete()) {
                $score += ($feature->numberOfTiles() * $feature->getTileValue());
            }
        }

        return $score;
    }
}
