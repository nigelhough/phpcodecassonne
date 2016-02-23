<?php

namespace Codecassonne;
use Codecassonne\Tile\Bag;
use Codecassonne\Tile\Mapper;

/**
 * Class Game
 *
 * Pull in and execute required game elements
 */
class Game
{

    /** @var Bag   A bag to hold our Tiles */
    private $bag;

    /** @var Mapper     A Mapper to get Tile Data from */
    private $tileMapper;

    /**
     * Construct the Game
     *
     * @param Mapper $tileMapper    A Mapper to get Tile Data from
     */
    public function __construct(Mapper $tileMapper)
    {
        $this->tileMapper = $tileMapper;
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

        $tiles = $this->tileMapper->findAll();

        foreach($tiles as $tile) {
            $this->bag->put($tile);
        }
    }
}
