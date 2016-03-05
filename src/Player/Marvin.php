<?php

namespace Codecassonne\Player;

use Codecassonne\Map\Map;
use Codecassonne\Tile\Tile;
use Codecassonne\Turn\Action;
use Codecassonne\Player\PlayerInterface;

class Marvin implements PlayerInterface
{
    /**
     * Get the name of a player
     *
     * @return string
     */
    public function getName()
    {
        return 'Marvin, the Paranoid Android';
    }

    /**
     * Play a turn
     *
     * @param Map  $map
     * @param Tile $tile
     *
     * @return Action
     * @throws \Exception
     */
    public function playTurn(Map $map, Tile $tile)
    {
        $playPositions = $map->getPlayablePositions();
        shuffle($playPositions);

        if (!$playPositions) {
            throw new \Exception('Unable to find any playable positions');
        }

        // Loop over playable positions
        foreach ($playPositions as $position) {
            //Loop over orientations
            for ($i = 0; $i < 4; $i++) {
                // Rotate tile
                try {
                    $map->place($tile, $position);
                    //If successfully placed, break out of rotation loop and positions loop
                    break 2;
                } catch (\Exception $e) {
                    $tile->rotate();
                }
            }
        }

        return new Action($position, $tile->getRotation());
    }
}
