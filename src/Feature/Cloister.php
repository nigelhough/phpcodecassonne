<?php

namespace Codecassonne\Feature;

/**
 * A Cloister feature on the board
 */
class Cloister
{
    /** @var int */
    protected $tileValue = 1;

    /** @var string */
    protected $tileType = \Codecassonne\Tile\Tile::TILE_TYPE_CLOISTER;
}
