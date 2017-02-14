<?php

namespace Codecassonne\Feature;

use Codecassonne\Map\Coordinate;

/**
 * A feature on the board
 **/
abstract class Feature
{
    /** @var Tile */
    private $tiles;

    /** @var int */
    protected $tileValue = 0;

    /** @var string */
    protected $tileType = \Codecassonne\Tile\Tile::TILE_TYPE_GRASS;

    /** @var bool */
    private $isComplete = false;

    /**
     * Construct a Feature Object
     *
     * @param bool   $isComplete Is the feature complete
     * @param Tile[] ...$tiles   The tiles that are part of the feature
     */
    public function __construct($isComplete, Tile ...$tiles)
    {
        $this->isComplete = $isComplete;

        // Add Tiles keyed by coordinate for ease of looking up
        foreach ($tiles as $tile) {
            if (array_key_exists($tile->getCoordinate(), $this->tiles)) {
                // @todo Custom Exception
                throw new \Exception('Can\'t pass two tiles on the same coordinate');
            }
            $this->tiles[$tile->getCoordinate()] = $tile;
        }
    }

    /**
     * If the feature is complete
     *
     * @return bool
     */
    public function isComplete(): bool
    {
        return $this->isComplete;
    }

    /**
     * The value of a tile in this feature
     *
     * @return int
     */
    public function getTileValue(): int
    {
        return $this->tileValue;
    }

    /**
     * The number of unique tiles that make up this feature
     *
     * @return int
     */
    public function numberOfTiles(): int
    {
        return count($this->tiles);
    }

    /**
     * Checks if a Coordinate and bearing is part of this feature
     *
     * @param Coordinate $coordinate Coordinate to check is part of the feature
     * @param string     $bearing    Bearing on the coordinate to check
     *
     * @return bool
     */
    public function isPartOfFeature(Coordinate $coordinate, string $bearing): bool
    {
        // @todo Workout if passed coordinate and bearing combinatiion is part of this feature
        return false;
    }
}
