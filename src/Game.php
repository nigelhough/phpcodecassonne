<?php

namespace Codecassonne;
use Codecassonne\Tile\Bag;
use Codecassonne\Tile\Tile;

/**
 * Class Game
 *
 * Pull in and execute required game elements
 */
class Game
{

    /** @var  Bag a bag to hold our Tiles */
    private $bag;

    function __construct()
    {

    }

    /**
     * Run the game
     */
    public function run()
    {
        $this->init();

        while (!$this->bag->isEmpty()) {
            $currentTile = $this->bag->drawFrom();
            echo $this->bag->getTileCount().PHP_EOL;
        }
    }

    /**
     * Initialise game variables
     *
     */
    private function init()
    {
        $this->bag = new Bag();
        for ($i = 0; $i < 10; $i++) {
            $this->bag->put(new Tile());
        }
    }
}