<?php

namespace Codecassonne\Tile;

/**
 * Class Tile
 */
class Tile
{
    const TILE_TYPE_GRASS   = 1;
    const TILE_TYPE_ROAD    = 2;
    const TILE_TYPE_CITY    = 3;

    /** @var  int   Type on Northern face of Tile*/
    private $north;

    /** @var  int   Type on Southern face of Tile*/
    private $south;

    /** @var  int   Type on Eastern face of Tile*/
    private $east;

    /** @var  int   Type on Western face of Tile*/
    private $west;

    /** @var  int   Type in center of Tile*/
    private $center;

    /**
     * Construct a new Tile
     *
     * @param int $north    Type on Northern face of Tile
     * @param int $east     Type on Eastern face of Tile
     * @param int $south    Type on Southern face of Tile
     * @param int $west     Type on Western face of Tile
     * @param int $center   Type in center of Tile
     */
    public function __construct($north, $east, $south, $west, $center)
    {
        //Set Tile properties
        $this->north = $north;
        $this->east = $east;
        $this->south = $south;
        $this->west = $west;
        $this->center = $center;
    }

    /**
     * Rotates a Tile clockwise
     */
    public function rotate()
    {
        $spare = $this->north;
        $this->north = $this->west;
        $this->west = $this->south;
        $this->south = $this->east;
        $this->east = $spare;
    }

    /**
     * Get the Tile faces
     *
     * @return array
     */
    public function getTileFaces()
    {
        return array(
            $this->north,
            $this->east,
            $this->south,
            $this->west,
            $this->center
        );
    }
}
