<?php

namespace Codecassonne\Feature;

/**
 * A City feature on the board
 */
class City
{
    /** @var int */
    protected $tileValue = 2;

    /** @var string */
    protected $tileType = \Codecassonne\Tile\Tile::TILE_TYPE_CITY;
}
