<?php

namespace Codecassonne\Player;

use Codecassonne\Map\Map;
use Codecassonne\Tile\Tile;
use Codecassonne\Turn\Action;
use Codecassonne\Map\Exception\InvalidTilePlacement;

class Marvin implements PlayerInterface
{
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Marvin, the Paranoid Android';
    }

    /**
     * @inheritdoc
     * @throws \Exception
     */
    public function playTurn(Map $map, Tile $tile)
    {
        $playPositions = $map->getPlayablePositions();
        shuffle($playPositions);

        if (!$playPositions) {
            throw new \Exception('Unable to find any playable positions');
        }

        $actionPosition = null;

        // Loop over playable positions
        foreach ($playPositions as $position) {
            //Loop over orientations
            for ($i = 0; $i < 4; $i++) {
                // Rotate tile
                try {
                    $map->place($tile, $position);
                    //If successfully placed, break out of rotation loop and positions loop
                    $actionPosition = $position;
                    break 2;
                } catch (InvalidTilePlacement $e) {
                    $tile->rotate();
                }
            }
        }

        return new Action($actionPosition, $tile->getRotation());
    }
}
