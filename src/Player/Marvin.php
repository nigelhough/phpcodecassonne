<?php
declare(strict_types = 1);

namespace Codecassonne\Player;

use Codecassonne\Map\Map;
use Codecassonne\Tile\Tile;
use Codecassonne\Turn\Action;
use Codecassonne\Map\Exception\InvalidTilePlacement;
use Codecassonne\Map\Coordinate;

/**
 * Marvin, the Paranoid Android Player
 */
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
     * Get playable positions
     *
     * @param Map $map Map to get playable positions on
     *
     * @return Coordinate[]
     * @throws Exception\NoValidMove
     */
    private function getPlayablePositions(Map $map)
    {
        // Get playable positions from the map
        $playPositions = $map->getPlayablePositions();

        // If no playable positions return early
        if (empty($playPositions)) {
            throw new Exception\NoValidMove('No Playable Positions on Map');
        }

        // Shuffle and return playable positions
        shuffle($playPositions);
        return $playPositions;
    }

    /**
     * Gets potential positions in each orientation
     *
     * @param Map $map Map to get playable positions on
     *
     * @return \Generator
     */
    private function getPotentialPosition(Map $map)
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
     * @inheritdoc
     * @throws Exception\NoValidMove
     */
    public function playTurn(Map $map, Tile $tile)
    {
        //Loop Over potential positions in each orientation
        foreach ($this->getPotentialPosition($map) as $position) {
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
        throw new Exception\NoValidMove('No Valid Moves for player to make');
    }
}
