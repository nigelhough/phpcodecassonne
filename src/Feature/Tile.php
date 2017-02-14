<?php

namespace Codecassonne\Feature;

use \Codecassonne\Map\Coordinate;

/**
 * A placed tile which is part of a feature
 */
class Tile
{
    /** @var \Codecassonne\Tile\Tile The tile that is part of the feature */
    private $tile;

    /** @var Coordinate The coordinate the features tile is on the Map */
    private $coordinate;

    /** @var array A list of the bearings on the tile that are part of the feature */
    private $bearings;

    /**
     * Construct a feature Tile
     *
     * @param \Codecassonne\Tile\Tile $tile       The tile that is part of the feature
     * @param Coordinate              $coordinate he coordinate the features tile is on the Map
     * @param array                   $bearings   A list of the bearings on the tile that are part of the feature
     */
    public function __construct(\Codecassonne\Tile\Tile $tile, Coordinate $coordinate, array $bearings)
    {
        $this->tile = $tile;
        $this->coordinate = $coordinate;
        $this->bearings = $bearings;
    }

    /**
     * Get the feature tiles coordinate on the map
     *
     * @return Coordinate
     */
    public function getCoordinate()
    {
        return $this->coordinate;
    }

    /**
     * Get the feature tiles tile
     *
     * @return \Codecassonne\Tile\Tile
     */
    public function getTile()
    {
        return $this->tile;
    }

    /**
     * Get the bearings on the tile which are part of the feature
     *
     * @return array
     */
    public function getBearings()
    {
        return $this->bearings;
    }
}
