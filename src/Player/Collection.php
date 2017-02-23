<?php

namespace Codecassonne\Player;

use Codecassonne\Player\PlayerInterface as Player;

/**
 * A Collection of Players
 */
class Collection implements \Countable
{
    /**
     * @var Player[]
     */
    private $players;

    /**
     * @var int
     */
    private $current;

    /**
     * Collection constructor.
     *
     * @param Player[] ...$players
     */
    public function __construct(Player ...$players)
    {
        $this->players = $players;

        $this->current = count($players) - 1;
    }

    /**
     * Get amount of players
     *
     * @return int
     */
    public function getPlayerCount()
    {
        return count($this->players);
    }

    /**
     * Returns the next player
     *
     * @return Player
     */
    public function next()
    {
        $this->current = ($this->current + 1) % count($this->players);

        return $this->players[$this->current];
    }

    /**
     * The number of players in the collection
     *
     * @return int
     */
    public function count()
    {
        return count($this->players);
    }
}
