<?php

namespace Codecassonne\Player;

use Codecassonne\Player\PlayerInterface as Player;

class Collection
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
     * @param Player|Player[] ...$players
     */
    public function __construct(Player ...$players)
    {
        $this->players = $players;

        $this->current = count($players);
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
}
