<?php

namespace Codecassonne\Scoring;

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
     * @todo Improve this, This is a very crude implementation of the scoring service, it was built up to pass integration tests
     * needs to be broken up by responsibility
     * needs to be more DRY
     * needs to have individual pieces of logic unit tested
     *
     * @return int Points scored for coordinate
     */
    public function calculateScore(Map $map, Coordinate $scoringCoordinate)
    {
        if (!$map->isOccupied($scoringCoordinate)) {
            throw new Exception\ScoringInvalidCoordinate('Can\'t score a coordinate that isn\'t occupied');
        }
        $score = 0;

        $score += $this->scoreFeatures($map, $scoringCoordinate);

        $score += $this->scoreCloisters($map, $scoringCoordinate);

        return $score;
    }

    /**
     * Score Features on a Coordinate
     *
     * @param Map        $map               Map to score fetaures on
     * @param Coordinate $scoringCoordinate Coordinate to score features on
     *
     * @return int
     */
    public function scoreFeatures(Map $map, Coordinate $scoringCoordinate)
    {
        $featuresScore = 0;

        $scoringTile = $map->look($scoringCoordinate);
        $scoringFeatures = $scoringTile->getFeatures();

        $overallScore = 0;

        // Iterate over all scoring features on the scoring tile
        foreach ($scoringFeatures as $featureFaces) {
            // Reset counters for new feature
            $featureScore = 0;
            $scoredCoordinates = [$scoringCoordinate];
            $scoredScoringTile = false;

            // Iterate over faces of the feature on the scoring tile
            foreach ($featureFaces as $bearing) {
                // Score the feature face
                $faceScore = $this->scoreFeature($map, $scoringCoordinate, $bearing, $scoringTile->getface($bearing), $scoredCoordinates);

                // If this face is incomplete, the whole feature is incomplete
                if ($faceScore === 0) {
                    // Set the feature score to 0 and break out of scoring the feature
                    $featureScore = 0;
                    break;
                }

                // Remove double counting of scoring tile
                if ($scoredScoringTile) {
                    $faceScore -= ($scoringTile->getface($bearing) === Tile::TILE_TYPE_CITY ? 2 : 1);
                }
                $scoredScoringTile = true;

                // Increment feature score
                $featureScore += $faceScore;
            }

            // Increment overall score
            $overallScore += $featureScore;
        }

        return $overallScore;
    }

    /**
     * Function to score a feature
     *
     * @param Map        $map                   Map to score a feature on
     * @param Coordinate $coordinate            Coordinate to score feature on
     * @param            $bearing               Bearing of the feature
     * @param            $tileType              Type of feature being scored
     * @param array      $scoredCoordinates     Coordinates that have already been scored so they aren't rescored
     *
     * @return int
     * @throws \Exception
     */
    private function scoreFeature(Map $map, Coordinate $coordinate, $bearing, $tileType, array &$scoredCoordinates = [])
    {
        // Score this tile
        $featureScore = ($tileType === Tile::TILE_TYPE_CITY ? 2 : 1);

        // Get coordinate touching the feature
        $touchingCoordinates = $coordinate->getTouchingCoordinates();
        if (!$touchingCoordinates[$bearing]) {
            throw new \Exception('Invalid Bearing');
        }
        $touchingCoordinate = $touchingCoordinates[$bearing];

        // If touching coordinate isn't occupied, feature can't be complete and scores zero
        if (!$map->isOccupied($touchingCoordinate)) {
            return 0;
        }

        // If the touching coordinate has been scored, feature must loops back, return score for just scored tile
        if (in_array($touchingCoordinate, $scoredCoordinates)) {
            return $featureScore;
        }

        // Add coordinate to scored list
        $scoredCoordinates[] = $touchingCoordinate;

        // Get Touching Tile
        $touchingTile = $map->look($touchingCoordinate);

        // Assume touching faces match and the Map isn't broken

        // If center of tile isn't the same feature this feature must be complete
        if ($touchingTile->getCenter() !== $tileType) {
            // Score joined tile which completes feature
            return $featureScore + ($tileType === Tile::TILE_TYPE_CITY ? 2 : 1);
        }

        // If center matches feature may continue
        // City, if center matches feature will continue in a direction possibly multiple
        // Road, if center matches feature may continue if feature in one direction, or stop if feature in multiple directions
        if ($touchingTile->getCenter() === Tile::TILE_TYPE_ROAD) {
            // Center tile is a road
            // Can't be a single road tile (wouldn't have a road center)
            // If there are two road faces on the tile it must connect two road features
            // If there are more than two road faces on the tile it must be a crossroads score features seperatley
            $roads =
                (int) ($touchingTile->getNorth() === Tile::TILE_TYPE_ROAD) +
                (int) ($touchingTile->getEast() === Tile::TILE_TYPE_ROAD) +
                (int) ($touchingTile->getSouth() === Tile::TILE_TYPE_ROAD) +
                (int) ($touchingTile->getWest() === Tile::TILE_TYPE_ROAD);

            // If there are more than two road faces on the tile it must be a crossroads score features seperatley
            if ($roads > 2) {
                // Score feature
                return $featureScore + 1;
            }

            // Score feature for matching face but not face being connected (The innverse to your face)
            if ($bearing != 'South' && $touchingTile->getNorth() === Tile::TILE_TYPE_ROAD) {
                $northScore = $this->scoreFeature($map, $touchingCoordinate, 'North', $touchingTile->getNorth(), $scoredCoordinates);
                // If joined feature is incomplete, whole feature scores 0
                if ($northScore === 0) {
                    return 0;
                }
                return $featureScore + $northScore;
            } elseif ($bearing != 'West' && $touchingTile->getEast() === Tile::TILE_TYPE_ROAD) {
                $eastScore = $this->scoreFeature($map, $touchingCoordinate, 'East', $touchingTile->getEast(), $scoredCoordinates);
                // If joined feature is incomplete, whole feature scores 0
                if ($eastScore === 0) {
                    return 0;
                }
                return $featureScore + $eastScore;
            } elseif ($bearing != 'North' && $touchingTile->getSouth() === Tile::TILE_TYPE_ROAD) {
                $southScore = $this->scoreFeature($map, $touchingCoordinate, 'South', $touchingTile->getSouth(), $scoredCoordinates);
                // If joined feature is incomplete, whole feature scores 0
                if ($southScore === 0) {
                    return 0;
                }
                return $featureScore + $southScore;
            } elseif ($bearing != 'East' && $touchingTile->getWest() === Tile::TILE_TYPE_ROAD) {
                $westScore = $this->scoreFeature($map, $touchingCoordinate, 'West', $touchingTile->getWest(), $scoredCoordinates);
                // If joined feature is incomplete, whole feature scores 0
                if ($westScore === 0) {
                    return 0;
                }
                return $featureScore + $westScore;
            }

        } elseif ($touchingTile->getCenter() === Tile::TILE_TYPE_CITY) {

            if ($bearing != 'South' && $touchingTile->getNorth() === Tile::TILE_TYPE_CITY) {
                $northScore = $this->scoreFeature($map, $touchingCoordinate, 'North', $touchingTile->getNorth(), $scoredCoordinates);
                // If connected feature is incomplete, entire feature is incomplete return 0
                if ($northScore === 0) {
                    return 0;
                }

                $featureScore += $northScore;
            }
            if ($bearing != 'West' && $touchingTile->getEast() === Tile::TILE_TYPE_CITY) {
                $eastScore = $this->scoreFeature($map, $touchingCoordinate, 'East', $touchingTile->getEast(), $scoredCoordinates);

                // If connected feature is incomplete, entire feature is incomplete return 0
                if ($eastScore === 0) {
                    return 0;
                }

                $featureScore += $eastScore;
            }
            if ($bearing != 'North' && $touchingTile->getSouth() === Tile::TILE_TYPE_CITY) {
                $southScore = $this->scoreFeature($map, $touchingCoordinate, 'South', $touchingTile->getSouth(), $scoredCoordinates);

                // If connected feature is incomplete, entire feature is incomplete return 0
                if ($southScore === 0) {
                    return 0;
                }

                $featureScore += $southScore;
            }
            if ($bearing != 'East' && $touchingTile->getWest() === Tile::TILE_TYPE_CITY) {
                $westScore = $this->scoreFeature($map, $touchingCoordinate, 'West', $touchingTile->getWest(), $scoredCoordinates);

                // If connected feature is incomplete, entire feature is incomplete return 0
                if ($westScore === 0) {
                    return 0;
                }

                $featureScore += $westScore;
            }

            $cities =
                (int) ($touchingTile->getNorth() === Tile::TILE_TYPE_CITY) +
                (int) ($touchingTile->getEast() === Tile::TILE_TYPE_CITY) +
                (int) ($touchingTile->getSouth() === Tile::TILE_TYPE_CITY) +
                (int) ($touchingTile->getWest() === Tile::TILE_TYPE_CITY);

            // Remove double counts of scored tile
            // Remove 1 because the city tile touching wasn't scored (don't consider that a double count)
            // Remove 1 because the tile should be scored once
            $featureScore -= (($cities - 2) * 2);

            return $featureScore;
        }

        //@todo Improve flow of function
        throw new \Exception('Should not get here');
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