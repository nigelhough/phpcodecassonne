<?php

namespace Codecassonne\Tile;

/**
 * Class Tile
 */
class Tile
{
    const TILE_TYPE_GRASS     = 'G';
    const TILE_TYPE_ROAD      = 'R';
    const TILE_TYPE_CITY      = 'C';
    const TILE_TYPE_CLOISTER  = 'M';

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

    /** @var int    Current tile rotation */
    private $rotation = 0;

    /** @var string Image representing Tile */
    private $tileImage;

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

        $this->tileImage = $north.$east.$south.$west.$center;
    }

    /**
     * Create a Tile from a string
     *
     * @param string $tileString   Tile as a String
     *
     * @returns self
     */
    public static function createFromString($tileString)
    {
        $faces = explode(':', $tileString);
        if (count($faces) != 5) {
            throw new \InvalidArgumentException("Invalid format for Tile ({$tileString}).");
        }

        //Validate the Faces of the Tile String are Valid
        foreach ($faces as $edge => $face) {
            if (!in_array($face, array(static::TILE_TYPE_GRASS, static::TILE_TYPE_CITY, static::TILE_TYPE_ROAD, static::TILE_TYPE_CLOISTER))) {
                throw new \InvalidArgumentException("Invalid format for Tile Face ({$face}).");
            }

            if ($face == static::TILE_TYPE_CLOISTER && $edge !== 4) {
                throw new \InvalidArgumentException("Cloister can only exist as the tile centre");
            }
        }

        //Return new Faces Object
        return new self(
            $faces[0],
            $faces[1],
            $faces[2],
            $faces[3],
            $faces[4]
        );
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

        $this->rotation = ($this->rotation + 90) % 360;
    }

    /**
     * Convert Tile Faces to String
     */
    public function toString()
    {
        return "{$this->north}:{$this->east}:{$this->south}:{$this->west}:{$this->center}";
    }

    /**
     * @return int
     */
    public function getNorth()
    {
        return $this->north;
    }

    /**
     * @return int
     */
    public function getSouth()
    {
        return $this->south;
    }

    /**
     * @return int
     */
    public function getEast()
    {
        return $this->east;
    }

    /**
     * @return int
     */
    public function getWest()
    {
        return $this->west;
    }

    /**
     * @return int
     */
    public function getCenter()
    {
        return $this->center;
    }

    /**
     * Tile image name
     *
     * @return string
     */
    public function getImage()
    {
        return $this->tileImage . '.png';
    }

    /**
     * Current tile rotation in degrees
     *
     * @return int
     */
    public function getRotation()
    {
        return $this->rotation;
    }
}
