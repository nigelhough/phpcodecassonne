<?php
declare(strict_types = 1);

namespace Codecassonne\Player;

use Codecassonne\Map\Map;
use Codecassonne\Turn\Action;
use Codecassonne\Map\Coordinate;

/**
 * Abstract Player
 */
abstract class Player implements PlayerInterface
{
    /**
     * Get playable positions
     *
     * @param Map $map Map to get playable positions on
     *
     * @return Coordinate[]
     * @throws Exception\NoPlayablePositions
     */
    protected function getPlayablePositions(Map $map)
    {
        // Get playable positions from the map
        $playPositions = $map->getPlayablePositions();

        // If no playable positions return early
        if (empty($playPositions)) {
            throw new Exception\NoPlayablePositions('No Playable Positions on Map');
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
    protected function getPotentialActions(Map $map)
    {
        // Loop over playable positions
        foreach ($this->getPlayablePositions($map) as $position) {
            // Loop over orientations
            for ($rotation = 0; $rotation <= 360; $rotation+=90) {
                yield new Action($position, $rotation);
            }
        }
    }
}
