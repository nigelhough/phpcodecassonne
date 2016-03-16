<?php

namespace Codecassonne\Player;

use Codecassonne\Map\Map;
use Codecassonne\Tile\Tile;
use Codecassonne\Turn\Action;
use Codecassonne\Map\Exception\InvalidTilePlacement;
use Codecassonne\Map\Coordinate;

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
     * Get playable positions
     *
     * @param Map $map  Map to get playable positions on
     *
     * @return Coordinate[]
     */
    private function getPlayablePositions(Map $map)
    {
        // Get playable positions from the map
        $playPositions = $map->getPlayablePositions();

        // If no playable positions return early
        if (!$playPositions) {
            return array();
        }

        // Shuffle and return playable positions
        shuffle($playPositions);
        return $playPositions;
    }

    /**
     * Gets potential positions in each orientation
     *
     * @param Map $map      Map to get playable positions on
     *
     * @return \Generator
     */
    public function getPotentialPosition(Map $map)
    {
        // Loop over playable positions
        foreach ($this->getPlayablePositions($map) as $position) {
            // Loop over orientations
            for ($i = 0; $i < 4; $i++) {
                yield $position;
            }
        }
    }

    /**
     * Play a turn
     *
     * @param Map  $map     Map to play turn on
     * @param Tile $tile    Tile to use in turn
     *
     * @return Action
     *
     * @throws Exception\NoPlayablePositions
     */
    public function playTurn(Map $map, Tile $tile)
    {
        //Loop Over potential positions in each orientation
        foreach($this->getPotentialPosition($map) AS $position) {
            try {
                $map->place($tile, $position);
                // If successfully placed, return action
                return new Action($position, $tile->getRotation());
            } catch (InvalidTilePlacement $e) {
                // Rotate tile
                $tile->rotate();
            }
        }

        // If the player hasn't found a valid action
        throw new Exception\NoPlayablePositions('Unable to find any playable positions');
    }
}
