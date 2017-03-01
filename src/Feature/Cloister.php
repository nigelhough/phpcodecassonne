<?php

namespace Codecassonne\Feature;

/**
 * A Cloister feature on the board
 */
class Cloister extends Feature
{
    /** @inheritDoc */
    protected $tileValue = 1;

    /** @inheritDoc */
    protected $featureType = \Codecassonne\Tile\Tile::TILE_TYPE_CLOISTER;
}
