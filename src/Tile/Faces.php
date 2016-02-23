<?php

namespace Codecassonne\Tile;

/**
 * Class Faces
 *
 * @property-read string $north
 * @property-read string $south
 * @property-read string $east
 * @property-read string $west
 * @property-read string $center
 */
class Faces
{
    /** @var  int   Type on Northern face of Tile */
    private $north;

    /** @var  int   Type on Southern face of Tile */
    private $south;

    /** @var  int   Type on Eastern face of Tile */
    private $east;

    /** @var  int   Type on Western face of Tile */
    private $west;

    /** @var  int   Type in center of Tile */
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
        $this->north    = $north;
        $this->east     = $east;
        $this->south    = $south;
        $this->west     = $west;
        $this->center   = $center;
    }

    /**
     * Create a Faces object from a string
     *
     * @param string $facesString   Specification of Tile Faces as a String
     *
     * @returns self
     */
    public static function createFromString($facesString)
    {
        $faces = explode(':', $facesString);
        if(count($faces) != 5) {
            throw new \InvalidArgumentException('Invalid string format for Tile Faces.');
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
     * Expose protected properties as read-only
     *
     * @param string $name Property name
     *
     * @return mixed
     * @throws \Exception
     */
    public function __get($name)
    {
        if (property_exists(get_class($this), $name)) {
            return $this->$name;
        }

        throw new \InvalidArgumentException('Property does not exist: ' . $name);
    }

    /**
     * Convert Tile Faces to String
     */
    public function toString()
    {
        return "{$this->north}:{$this->east}:{$this->south}:{$this->west}:{$this->center}";
    }
}
