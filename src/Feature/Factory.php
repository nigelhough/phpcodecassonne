<?php

namespace Codecassonne\Feature;

use \Codecassonne\Map\Coordinate;
use \Codecassonne\Map\Map;

/**
 * Constructs feature objects
 */
class Factory
{
    /**
     * Create a feature from a starting coordinate and a bearing on that tile
     *
     * @param Map        $map              Map the feature is on
     * @param Coordinate $startingLocation Starting location to look for a feature
     * @param string     $bearing          Bearing of the tile the feature starts
     *
     * @return Feature
     */
    public function createFeature(Coordinate $startingLocation, \Codecassonne\Map\Map $map, $bearing): Feature
    {
        // Check the coordinate has a tile

        // Check the tile has feature(s)

        // Check there is a feature on the requested bearing
    }

    /**
     * Create features for all starting at a coordinate
     *
     * @param Coordinate $startingLocation
     * @param Map        $map
     *
     * @return Feature[]
     */
    public function createFeatures(Coordinate $startingLocation, \Codecassonne\Map\Map $map): array
    {
        // Check the coordinate has a tile

        // Check the tile has feature(s)
    }
}
