<?php
declare(strict_types = 1);

namespace Codecassonne\Turn;

use Codecassonne\Map\Coordinate;
use Codecassonne\Map\Map;
use Codecassonne\Tile\Tile;
use Codecassonne\Scoring;

/**
 * The action to be taken for laying a tile on a map
 */
final class Action
{
    /**
     * @var Coordinate
     */
    private $coordinate;

    /**
     * @var int
     */
    private $rotation;

    /**
     * Action constructor.
     *
     * @param Coordinate $coordinate
     * @param int        $rotation
     */
    public function __construct(Coordinate $coordinate, $rotation)
    {
        $this->coordinate = $coordinate;
        $this->rotation = $rotation;
    }

    /**
     * Run action against Map using Tile
     *
     * @param Map  $map
     * @param Tile $tile
     *
     * @throws \InvalidArgumentException
     * @throws \Codecassonne\Map\Exception\InvalidTilePlacement
     */
    public function run(Map $map, Tile $tile)
    {
        $tile->rotateTo($this->rotation);
        $map->place($tile, $this->coordinate);
    }

    /**
     * Calculate score for an Action
     *
     * @param Map             $map     Map to score action on
     * @param Scoring\Service $scoring Service for scoring a game
     *
     * @return int
     */
    public function score(Map $map, Scoring\Service $scoring)
    {
        return $scoring->calculateScore($map, $this->coordinate);
    }

    /**
     * @return Coordinate
     */
    public function getCoordinate()
    {
        return $this->coordinate;
    }

    /**
     * @return int
     */
    public function getRotation()
    {
        return $this->rotation;
    }
}
