<?php

namespace Codecassonne\Player;

/**
 * A Collection of Players
 */
class Collection implements \Countable
{
    /**
     * @var PlayerInterface[]
     */
    private $players;

    /**
     * @var int
     */
    private $current;

    /**
     * Collection constructor.
     *
     * @param PlayerInterface ...$players    Players in the collection
     */
    public function __construct(PlayerInterface ...$players)
    {
        $this->players = $players;

        $this->current = count($players) - 1;
    }

    /**
     * Returns the next player
     *
     * @return PlayerInterface
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
