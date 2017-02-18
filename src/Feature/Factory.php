<?php

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
     */
    public function createFeature(Coordinate $startingCoordinate, Map $map, string $bearing): Feature
    {
        $startingTile = $map->look($startingCoordinate);

        $featureFaces = $startingTile->getFeature($bearing);

        if (empty($featureFaces)) {
            throw new Exception\NoFeatureFaces('Can\'t create a feature with no feature faces');
        }

        $isComplete = true;
        $featureTiles = [];

        $featureTiles[$startingCoordinate->toHash()] = new Tile($startingTile, $startingCoordinate, $featureFaces);
        foreach ($featureFaces as $featureBearing) {
            $this->findFeatureTiles($map, $startingCoordinate, $featureBearing, $featureTiles, $isComplete);
        }

        $featureType = $map->look($startingCoordinate)->getFace($featureFaces[0]);

        if ($featureType === \Codecassonne\Tile\Tile::TILE_TYPE_CITY) {
            return new City($isComplete, ...array_values($featureTiles));
        } elseif ($featureType === \Codecassonne\Tile\Tile::TILE_TYPE_ROAD) {
            return new Road($isComplete, ...array_values($featureTiles));
        }
    }

    private function findFeatureTiles(
        Map $map,
        Coordinate $coordinate,
        string $bearing,
        array &$featureTiles,
        bool &$isComplete
    ) {
        // Get Connected Coordinate
        $connectedCoordinate = $coordinate->getBearing($bearing);

        // Need to check if tile is already in the list and return, looped features
        if (array_key_exists($connectedCoordinate->toHash(), $featureTiles)) {
            // Currentley no tile can loop back and start another feature, they must join back to original or stop
            // In future expansions this is possible but how to define that tile hasn't been defined
            // Add code here in the future to continue looping back features on the same tile
            return;
        }

        if (!$map->isOccupied($connectedCoordinate)) {
            // If the connected coordinate doesn't have a placed tile the feature is incomplete
            $isComplete = false;
            return;
        }

        // Find Tile, assuming a tile face match or its an invalid map
        $connectedTile = $map->look($connectedCoordinate);
        $connectedBearing = $this->flipBearing($bearing);
        $connectedFeature = $connectedTile->getFeature($connectedBearing);

        // Create feature tile, add to tracked tiles
        $featureTiles[$connectedCoordinate->toHash()] = new Tile($connectedTile, $connectedCoordinate, $connectedFeature);

        if (count($connectedFeature) === 1) {
            // If only one face in the feature it is closed
            return;
        }

        // More than one face
        // Recursivley search Linked Tile Features
        var_dump('Add Code for Multiple Connected Features');
        exit;
    }

    /**
     * @param $bearing
     *
     * @todo Move this into a more appropriate place, probably time for bearing objects
     *
     * @return string
     */
    private function flipBearing($bearing)
    {
        switch ($bearing) {
            case 'North' :
                return 'South';
                break;
            case 'East' :
                return 'West';
                break;
            case 'South' :
                return 'North';
                break;
            case 'West' :
                return 'East';
                break;
        }

        // @todo Custom Exception
        throw new \Exception('Invalid Bearing');
    }

    /**
     * Create features for all starting at a coordinate
     *
     * @param Coordinate $startingCoordinate
     * @param Map        $map
     *
     * @return Feature[]
     */
    public function createFeatures(Coordinate $startingCoordinate, Map $map): array
    {
        // Check the coordinate has a tile
        // Check the tile has feature(s)
        // Handle Cloisters
    }
}
