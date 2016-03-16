<?php

namespace Codecassonne\Turn;


use Codecassonne\Map\Coordinate;
use Codecassonne\Map\Map;
use Codecassonne\Tile\Tile;

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
