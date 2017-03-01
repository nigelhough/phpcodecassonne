<?php
declare(strict_types = 1);

namespace Codecassonne\Scoreboard;

use Codecassonne\Player\PlayerInterface;

/**
 * A class to hold a players score
 */
class PlayerScore
{
    /** @var PlayerInterface The player the score belongs to */
    private $player;

    /** @var  int The score of the player */
    private $score;

    /**
     * PlayerScore constructor.
     *
     * @param PlayerInterface $player The player the score belongs to
     * @param int             $score  The score of the player
     */
    public function __construct(PlayerInterface $player, int $score = 0)
    {
        $this->player = $player;
        $this->score = $score;
    }

    /**
     * Add additional points to a players score
     *
     * @param int $score Number of points to add
     *
     * @throws Exception\InvalidScore
     */
    public function incrementScore(int $score)
    {
        if ($score <= 0) {
            throw new Exception\InvalidScore('Must be positive');
        }

        $this->score += $score;
    }

    /**
     * Get the player the score belongs to
     *
     * @return PlayerInterface
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Get the players score
     *
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }
}
