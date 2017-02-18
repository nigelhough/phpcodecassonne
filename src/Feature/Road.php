<?php

namespace Codecassonne\Feature;

/**
 * A Road feature on the board
 */
class Road extends Feature
{
    /** @inheritDoc */
    protected $tileValue = 1;

    /** @inheritDoc */
    protected $featureType = \Codecassonne\Tile\Tile::TILE_TYPE_ROAD;
}
