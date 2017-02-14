<?php

namespace Codecassonne\Feature;

/**
 * A Road feature on the board
 */
class Road
{
    /** @var int */
    protected $tileValue = 1;

    /** @var string */
    protected $tileType = \Codecassonne\Tile\Tile::TILE_TYPE_ROAD;
}
