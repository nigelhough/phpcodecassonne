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
class Kryten extends Marvin
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
     * @throws \Exception
     */
    public function playTurn(Map $map, Tile $tile)
    {
        $playPositions = $map->getPlayablePositions();

        if (empty($playPositions)) {
            throw new \Exception('Unable to find any playable positions');
        }

        $highestScore = null;
        $highestPosition = null;
        $highestRotation = null;

        // Loop over playable positions
        foreach ($playPositions as $position) {
            //Loop over orientations
            for ($i = 0; $i < 4; $i++) {
                // Rotate tile
                try {
                    // Attempt tile placement
                    $placingMap = clone $map;
                    $placingMap->place($tile, $position);

                    // Score tile placement
                    $scoringService = new Service();
                    $score = $scoringService->calculateScore($placingMap, $position);

                    // If this is better than the highest score, make this the highest score
                    if (is_null($highestScore) || $score > $highestScore) {
                        $highestScore = $score;
                        $highestPosition = $position;
                        $highestRotation = $tile->getRotation();
                    }
                } catch (InvalidTilePlacement $e) {
                    // Move is invalid try again
                }

                $tile->rotate();
            }
        }

        if (is_null($highestPosition)) {
            throw new Exception\NoValidMove('No Valid Moves for player to make');
        }

        return new Action($highestPosition, $highestRotation);
    }
}
