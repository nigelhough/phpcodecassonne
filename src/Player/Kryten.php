<?php
declare(strict_types = 1);

namespace Codecassonne\Player;

use Codecassonne\Map\Map;
use Codecassonne\Tile\Tile;
use Codecassonne\Turn\Action;
use Codecassonne\Scoring\Service;
use Codecassonne\Map\Exception\InvalidTilePlacement;

/**
 * A Player that plays the highest scoring move possible
 */
class Kryten extends Player
{
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Kryten, Series 4000 Sanitation Droid';
    }

    /**
     * @inheritdoc
     * @throws Exception\NoValidMove
     */
    public function playTurn(Map $map, Tile $tile)
    {
        $highestScore = null;
        /** @var Action $highestScoringAction Highest scoring action */
        $highestScoringAction = null;
        $scoringService = new Service();

        /** @var Action $action Potential Actions to play*/
        foreach ($this->getPotentialActions($map) as $action) {
            try {
                // Test on a clean map that hasn't run any other potential actions
                $scoringMap = clone $map;
                // Run action
                $action->run($scoringMap, $tile);
                // Score Action
                $score = $action->score($scoringMap, $scoringService);
                // If this is better than the highest score, make this the highest score
                if (is_null($highestScore) || $score > $highestScore) {
                    $highestScore = $score;
                    $highestScoringAction = $action;
                }
            } catch (InvalidTilePlacement $e) {
                // Invalid move, try next rotation or tile
                // @todo Add is ValidAction function that doesn't require placement
            }
        }

        if (is_null($highestScoringAction)) {
            throw new Exception\NoValidMove('No Valid Moves for player to make');
        }

        return $highestScoringAction;
    }
}
