<?php

namespace Codecassonne\Feature;

use Codecassonne\Map\Coordinate;

/**
 * A feature on the board
 **/
abstract class Feature
{
    /** @var Tile[] The placed feature tiles that make-up this feature */
    private $tiles;

    /** @var int The value each tile will score on a completed feature */
    protected $tileValue = 0;

    /** @var string The face type of the feature */
    protected $featureType = \Codecassonne\Tile\Tile::TILE_TYPE_GRASS;

    /** @var bool Is the feature completed */
    private $isComplete = false;

    /**
     * Construct a Feature Object
     *
     * @param bool   $isComplete Is the feature complete
     * @param Tile[] $tiles      The tiles that are part of the feature
     */
    public function __construct($isComplete, Tile ...$tiles)
    {
        $this->isComplete = $isComplete;

        // Add Tiles keyed by coordinate for ease of looking up
        foreach ($tiles as $tile) {
            if (array_key_exists($tile->getCoordinate()->toHash(), $this->tiles)) {
                // @todo Custom Exception
                throw new \Exception('Can\'t pass two tiles on the same coordinate');
            }
            $this->tiles[$tile->getCoordinate()->toHash()] = $tile;
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
     * The type of feature this is
     *
     * @return string
     */
    public function getFeatureType(): string
    {
        return $this->featureType;
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
     * Checks if a Coordinate is part of this feature
     *
     * @param Coordinate $coordinate Coordinate to check is part of the feature
     *
     * @return bool
     */
    public function coordinatePartOf(Coordinate $coordinate) : bool
    {
        return array_key_exists($coordinate->toHash(), $this->tiles);
    }

    /**
     * Checks if a Coordinate and bearing is part of this feature
     *
     * @param Coordinate $coordinate Coordinate to check is part of the feature
     * @param string     $bearing    Bearing on the coordinate to check
     *
     * @return bool
     */
    public function coordinateBearingPartOf(Coordinate $coordinate, string $bearing): bool
    {
        // If coordinate is not part of this feature return early
        if (!$this->coordinatePartOf($coordinate)) {
            return false;
        }

        $featureTile = $this->tiles[$coordinate->toHash()];
        return $featureTile->bearingPartOf($bearing);
    }
}
