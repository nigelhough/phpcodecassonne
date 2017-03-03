<?php

namespace Codecassonne\Player;

use Codecassonne\Map\Map;
use Codecassonne\Tile\Tile;
use Codecassonne\Turn\Action;

/**
 * Details the interfaces a player must expose
 */
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
