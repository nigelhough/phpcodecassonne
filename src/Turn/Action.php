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

    public function run(Map $map, Tile $tile)
    {
        $tile->rotateTo($this->rotation);
        $map->place($tile, $this->coordinate);
    }
}
