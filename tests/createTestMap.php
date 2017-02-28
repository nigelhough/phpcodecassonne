<?php

namespace Codecassonne;

use Codecassonne\Map\Map;
use Codecassonne\Map\Coordinate;
use Codecassonne\Tile\Tile;

/**
 * Functions for creating a dummy map for unit tests
 */
trait createTestMap
{
    /**
     * Creates a map from an array of tiles
     *
     * @param array $tiles Array of tiles to set the state of the map
     *
     * @return Map
     */
    protected function createMap(array $tiles)
    {
        //Dummy Tile
        $tile = Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS);

        // Create Map
        $map = new Map($tile);

        // Make Map properties accessible
        $mapReflection = new \ReflectionClass('Codecassonne\Map\Map');
        $tilesReflection = $mapReflection->getProperty('tiles');
        $tilesReflection->setAccessible(true);

        // Set the Maps Tiles
        $tilesReflection->setValue($map, $tiles);

        // Sets the map size, used to render the map, not required for tests unless visualising map, good for debugging
        // Update the Bottom Left Coordinate of the map
        $bottomLeftReflection = $mapReflection->getProperty('bottomLeft');
        $bottomLeftReflection->setAccessible(true);
        $bottomLeftReflection->setValue(
            $map,
            new Coordinate(
                -3,
                -3
            )
        );
        // Update the Top Right Coordinate of the map
        $topRightReflection = $mapReflection->getProperty('topRight');
        $topRightReflection->setAccessible(true);
        $topRightReflection->setValue(
            $map,
            new Coordinate(
                3,
                3
            )
        );

        return $map;
    }
}
