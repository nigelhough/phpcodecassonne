<?php

namespace Codecassonne\Feature;

/**
 * A City feature on the board
 */
class City extends Feature
{
    /** @inheritDoc */
    protected $tileValue = 2;

    /** @inheritDoc */
    protected $featureType = \Codecassonne\Tile\Tile::TILE_TYPE_CITY;
}
