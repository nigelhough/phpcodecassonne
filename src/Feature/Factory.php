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
        $feature = $startingTile->getFeature($bearing);
        if (empty($feature)) {
            throw new Exception\NoFeatureFaces('Can\'t create a feature with no feature faces');
        }

        // Recursively find features connected to starting tile
        $featureTiles = [];
        $featureTiles[$startingCoordinate->toHash()] = new Tile($startingTile, $startingCoordinate, $featureTiles);
        $isComplete = $this->findConnectedfeatures($map, $startingCoordinate, $feature, $featureTiles);

        return $this->constructFeature($startingTile->getFace($bearing), $isComplete, $featureTiles);
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

            if ($this->isCoordinateBearingPartOfFeatures($startingCoordinate, $bearing, $features)) {
                // Connected to an existing feature (loop back), Skip as already counted
                continue(1);
            }

            // Get feature for bearing
            $features[] = $this->createFeature($startingCoordinate, $map, $bearing);
        }

        return array_merge($features, $cloisters);
    }

    /**
     * Checks if a Coordinate and bearing is part of a collection of features
     *
     * @param Coordinate $coordinate Coordinate to check is part of the feature
     * @param string     $bearing    Bearing on the coordinate to check
     * @param Feature[]  $features   Collection of features to check
     *
     * @return bool
     */
    private function isCoordinateBearingPartOfFeatures(Coordinate $coordinate, string $bearing, array $features): bool
    {
        // Check if bearing is already part of another feature
        foreach ($features as $feature) {
            if ($feature->coordinateBearingPartOf($coordinate, $bearing)) {
                return true;
            }
        }

        return false;
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
     * Construct a Feature to construct
     *
     * @param string $featureType  Type of feature to construct
     * @param bool   $isComplete   If the feature is complete
     * @param Tile[] $featureTiles The tiles that make-up the feature
     *
     * @return Feature
     * @throws \Exception
     */
    private function constructFeature(string $featureType, bool $isComplete, array $featureTiles): Feature
    {
        $validFeatureTypes = [\Codecassonne\Tile\Tile::TILE_TYPE_CITY, \Codecassonne\Tile\Tile::TILE_TYPE_ROAD];
        if (!in_array($featureType, $validFeatureTypes)) {
            // @todo Custom Exception
            throw new \Exception('Invalid Feature Type');
        }

        if ($featureType === \Codecassonne\Tile\Tile::TILE_TYPE_CITY) {
            return new City($isComplete, ...array_values($featureTiles));
        }

        return new Road($isComplete, ...array_values($featureTiles));
    }

    /**
     * Recursively find feature tiles connected to a feature
     *
     * @param Map        $map           Map to find features on
     * @param Coordinate $coordinate    Coordinate feature is on
     * @param string[]   $feature       Bearings of tile that feature occupies
     * @param Tile[]     $featureTiles  Tiles making up the overall feature
     * @param string     $ignoreBearing Bearing on the feature to ignore
     *
     * @return bool
     */
    private function findConnectedfeatures(
        Map $map,
        Coordinate $coordinate,
        array $feature,
        array &$featureTiles,
        string $ignoreBearing = null
    ): bool {
        // If only one face in the feature it is closed
        if (count($feature) === 0) {
            return true;
        }

        // More than one face
        // Recursively search Linked Tile Features
        $isComplete = true;
        foreach ($feature as $featureBearing) {
            if (!is_null($ignoreBearing) && $featureBearing === $ignoreBearing) {
                continue;
            }
            $partComplete = $this->findFeatureTiles($map, $coordinate, $featureBearing, $featureTiles);
            $isComplete = ($isComplete && $partComplete);
        }
        return $isComplete;
    }

    /**
     * Recursively find features tiles connected to a tile bearing
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

        // Recursively search Linked Tile Features, ignoring the tile just connected via
        return $this->findConnectedfeatures(
            $map,
            $connectedCoordinate,
            $connectedFeatures,
            $featureTiles,
            $connectedBearing
        );
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
    private function flipBearing(string $bearing): string
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
