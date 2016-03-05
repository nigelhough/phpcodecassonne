<?php

namespace Codecassonne\Turn;

use Codecassonne\Map\Map;
use Codecassonne\Tile\Tile;

interface PlayerInterface
{
    /**
     * Get the name of a player
     *
     * @return string
     */
    public function getName();

    /**
     * Play a turn
     *
     * @param Map  $map
     * @param Tile $tile
     *
     * @return Action
     */
    public function playTurn(Map $map, Tile $tile);
}
