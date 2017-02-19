<?php

namespace Codecassonne\Scoring;

use Codecassonne\Feature\Factory;
use Codecassonne\Map\Map;
use Codecassonne\Tile\Tile;
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

        $score += $this->scoreCloisters($map, $scoringCoordinate);

        return $score;
    }

    /**
     * Score Cloisters, Cloisters need to be completrley surrounded to score 9 points (a point per tile
     *
     * @param Map        $map               Map to score coordinate on
     * @param Coordinate $scoringCoordinate Coordinate to score
     *
     * @return int Points scored from cloisters
     */
    private function scoreCloisters(Map $map, Coordinate $scoringCoordinate)
    {
        $cloisterScore = 0;
        /** @var Coordinate[] $cloisterCoordinates */
        $cloisterCoordinates = [];

        // If played piece is a cloister
        if ($map->look($scoringCoordinate)->getCenter() === Tile::TILE_TYPE_CLOISTER) {
            $cloisterCoordinates[] = $scoringCoordinate;
        }

        // Check if any of the surrounding coordinates are cloisters that this might complete
        foreach ($scoringCoordinate->getSurroundingCoordinates() as $coordinate) {
            // If the surrounding coordinate is not occupied, not a cloister
            if (!$map->isOccupied($coordinate)) {
                continue;
            }

            if ($map->look($coordinate)->getCenter() === Tile::TILE_TYPE_CLOISTER) {
                $cloisterCoordinates[] = $coordinate;
            }
        }

        // If there are no cloisters to score, then the score is zero
        if (empty($cloisterCoordinates)) {
            return 0;
        }

        // For all the cloisters
        foreach ($cloisterCoordinates as $cloisterCoordinate) {
            // Find all of the surrounding coordinates
            foreach ($cloisterCoordinate->getSurroundingCoordinates() as $coordinate) {
                // If not occupied, not complete
                if (!$map->isOccupied($coordinate)) {
                    // Skip to next Cloister
                    continue(2);
                }
            }
            // If surrounded, score 9 points
            $cloisterScore += 9;
        }

        return $cloisterScore;
    }
}
