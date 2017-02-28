<?php
declare(strict_types = 1);

namespace Codecassonne\Feature;

use Codecassonne\Map\Coordinate;
use Codecassonne\Map\Map;

/**
 * Constructs feature objects
 */
class Factory
{
    /**
     * Create a feature from a starting coordinate and a bearing on that tile
     *
     * @param Map        $map                Map the feature is on
     * @param Coordinate $startingCoordinate Starting coordinate to look for a feature
     * @param string     $bearing            Bearing of the tile the feature starts
     *
     * @return Feature
     * @throws Exception\NoFeatureFaces
     * @throws \Exception
     */
    public function createFeature(Coordinate $startingCoordinate, Map $map, string $bearing): Feature
    {
        // Get Feature for Starting Tile
        $startingTile = $map->look($startingCoordinate);
        $featureFaces = $startingTile->getFeature($bearing);
        if (empty($featureFaces)) {
            throw new Exception\NoFeatureFaces('Can\'t create a feature with no feature faces');
        }

        // Recursively find features connected to starting tile
        $isComplete = true;
        $featureTiles = [];
        $featureTiles[$startingCoordinate->toHash()] = new Tile($startingTile, $startingCoordinate, $featureFaces);
        foreach ($featureFaces as $featureBearing) {
            $partComplete = $this->findFeatureTiles($map, $startingCoordinate, $featureBearing, $featureTiles);

            // Feature complete if all parts are complete
            $isComplete = ($isComplete && $partComplete);
        }

        // Construct Feature Object
        $featureType = $startingTile->getFace($bearing);
        if ($featureType === \Codecassonne\Tile\Tile::TILE_TYPE_CITY) {
            return new City($isComplete, ...array_values($featureTiles));
        } elseif ($featureType === \Codecassonne\Tile\Tile::TILE_TYPE_ROAD) {
            return new Road($isComplete, ...array_values($featureTiles));
        }

        // @todo Custom Exception
        throw new \Exception('Invalid Feature Type');
    }

    /**
     * Recursively find features connected to a tile bearing
     *
     * @param Map        $map          Map to find features on
     * @param Coordinate $coordinate   Coordinate to find from
     * @param string     $bearing      Bearing to find from
     * @param Tile[]     $featureTiles feature tiles already in the feature
     *
     * @return bool Is the feature complete
     */
    private function findFeatureTiles(
        Map $map,
        Coordinate $coordinate,
        string $bearing,
        array &$featureTiles
    ): bool {
        // Get Connected Coordinate
        $connectedCoordinate = $coordinate->getBearing($bearing);

        // If the connected coordinate doesn't have a placed tile the feature is incomplete
        if (!$map->isOccupied($connectedCoordinate)) {
            return false;
        }

        // Find Tile, assuming a tile face match or its an invalid map
        $connectedTile = $map->look($connectedCoordinate);
        $connectedBearing = $this->flipBearing($bearing);
        $connectedFeatures = $connectedTile->getFeature($connectedBearing);

        // Need to check if tile is already in the list and return, looped features
        if (array_key_exists($connectedCoordinate->toHash(), $featureTiles)) {
            // Currently no tile can loop back and start another feature path, they must join back to original or stop
            // In future expansions this is possible but how to define that tile hasn't been defined
            // Add code here in the future to continue looping back features on the same tile

            // Is Connected bearing already part of the feature?
            $currentFeatureTile = $featureTiles[$connectedCoordinate->toHash()];
            if (!$currentFeatureTile->bearingPartOf($connectedBearing)) {
                // If not merge the connected bearing with the bearings already found for coordinate
                $currentBearings = $currentFeatureTile->getBearings();
                $featureTiles[$connectedCoordinate->toHash()] =
                    new Tile(
                        $connectedTile,
                        $connectedCoordinate,
                        array_merge($currentBearings, $connectedFeatures)
                    );
            }

            // Currently feature must be complete (loop back or stop)
            return true;
        }

        // Create feature tile, add to tracked tiles
        $featureTiles[$connectedCoordinate->toHash()] =
            new Tile($connectedTile, $connectedCoordinate, $connectedFeatures);

        if (count($connectedFeatures) === 1) {
            // If only one face in the feature it is closed
            return true;
        }

        // More than one face
        // Recursively search Linked Tile Features
        $isComplete = true;
        foreach ($connectedFeatures as $connectedFeature) {
            if ($connectedFeature === $connectedBearing) {
                continue;
            }
            $partComplete = $this->findFeatureTiles($map, $connectedCoordinate, $connectedFeature, $featureTiles);
            $isComplete = ($isComplete && $partComplete);
        }
        return $isComplete;
    }

    /**
     * Flips a bearing
     *
     * @param string $bearing The bearing to flip
     *
     * @todo Move this into a more appropriate place, probably time for bearing objects
     *
     * @return string
     * @throws \Exception
     */
    private function flipBearing(string $bearing) : string
    {
        switch ($bearing) {
            case 'North':
                return 'South';
            case 'East':
                return 'West';
            case 'South':
                return 'North';
            case 'West':
                return 'East';
        }

        // @todo Custom Exception
        throw new \Exception('Invalid Bearing');
    }

    /**
     * Create features for all starting at a coordinate
     * Should invalid coordinates throw Exceptions?
     *
     * @param Coordinate $startingCoordinate Starting coordinate to look for a feature
     * @param Map        $map                Map the feature is on
     *
     * @return Feature[]
     */
    public function createFeatures(Coordinate $startingCoordinate, Map $map): array
    {
        // If the starting coordinate doesn't have a tile there are no features
        if (!$map->isOccupied($startingCoordinate)) {
            return [];
        }

        // Score Cloisters, on tile and surrounding
        $cloisters = $this->createCloisters($map, $startingCoordinate);

        // Get Feature for Starting Tile
        $startingTile = $map->look($startingCoordinate);
        $startingFeatures = $startingTile->getFeatures();
        // If the starting coordinate doesn't have any features return early
        if (empty($startingFeatures)) {
            return $cloisters;
        }

        /** @var Feature[] $features */
        $features = [];

        foreach ($startingFeatures as $startingFeature) {
            // Get a bearing from the starting feature
            $bearing = $startingFeature[0];

            // Check if bearing is already part of another feature
            foreach ($features as $feature) {
                if ($feature->coordinateBearingPartOf($startingCoordinate, $bearing)) {
                    // Skip as already counted by a connected feature on tile
                    continue(2);
                }
            }

            // Get feature for bearing
            $features[] = $this->createFeature($startingCoordinate, $map, $bearing);
        }

        return array_merge($features, $cloisters);
    }

    /**
     * Create all Cloisters linked to a tile
     *
     * @param Map        $map        Map the cloisters are on is on
     * @param Coordinate $coordinate Coordinate linked to cloisters
     *
     * @return Cloister[]
     */
    public function createCloisters(Map $map, Coordinate $coordinate): array
    {
        $features = [];

        // Check coordinate and all surrounding for existence of Cloisters
        $checkCoordinates = array_merge([$coordinate], $coordinate->getSurroundingCoordinates());
        foreach ($checkCoordinates as $checkCoordinate) {
            if ($this->isCloister($map, $checkCoordinate)) {
                $features[] = $this->createCloister($map, $checkCoordinate);
            }
        }

        return $features;
    }

    /**
     * Checks if a given coordinate is a Cloister
     *
     * @param Map        $map        Map to check coordinate on
     * @param Coordinate $coordinate Coordinate to check
     *
     * @return bool
     */
    private function isCloister(Map $map, Coordinate $coordinate): bool
    {
        return $map->isOccupied($coordinate)
            && $map->look($coordinate)->getCenter() === \Codecassonne\Tile\Tile::TILE_TYPE_CLOISTER;
    }

    /**
     * Create a cloister centered on a specific coordinate
     *
     * @param Map        $map        Map the cloisters are on is on
     * @param Coordinate $coordinate Coordinate linked to cloisters
     *
     * @return Cloister
     *
     * @throws \Codecassonne\Feature\Exception\NotCloister
     */
    private function createCloister(Map $map, Coordinate $coordinate): Cloister
    {
        if (!$this->isCloister($map, $coordinate)) {
            throw new Exception\NotCloister('Cloister must have a cloister at the center of the tile');
        }

        // Construct a Cloister with all of the surrounding tiles
        $featureCoordinates = [new Tile($map->look($coordinate), $coordinate, [])];
        foreach ($coordinate->getSurroundingCoordinates() as $checkCoordinate) {
            if ($map->isOccupied($checkCoordinate)) {
                $featureCoordinates[] =
                    new Tile($map->look($checkCoordinate), $checkCoordinate, []);
            }
        }

        return new Cloister((count($featureCoordinates) === 9), ...$featureCoordinates);
    }
}
