<?php
declare(strict_types = 1);

namespace Codecassonne\Player;

use Codecassonne\Map\Map;
use Codecassonne\Tile\Tile;
use Codecassonne\Turn\Action;
use Codecassonne\Map\Exception\InvalidTilePlacement;

/**
 * Marvin, the Paranoid Android Player
 */
class Marvin extends Player
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
     * @throws Exception\NoValidMove
     */
    public function playTurn(Map $map, Tile $tile)
    {
        /** @var Action $action Potential Actions to play*/
        foreach ($this->getPotentialActions($map) as $action) {
            try {
                // Run action, this is a clone of the game map, so can be placed without affecting it
                $action->run($map, $tile);
                // If successfully placed, return action
                return $action;
            } catch (InvalidTilePlacement $e) {
                // Invalid move, try next rotation or tile
                // @todo Add is ValidAction function that doesn't require placement
            }
        }

        // If the player hasn't found a valid action
        throw new Exception\NoValidMove('No Valid Moves for player to make');
    }
}
