<?php

namespace Codecassonne;
use Codecassonne\Map\Map;
use Codecassonne\Tile\Bag;
use Codecassonne\Tile\Mapper\MapperInterface as Mapper;

/**
 * Class Game
 *
 * Pull in and execute required game elements
 */
class Game
{
    /** @var Map    The map to lay tiles on  */
    private $map;

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
        echo `clear`;
        echo 'Starting.' . PHP_EOL;
        $this->map->render();
        sleep(1);

        while (!$this->bag->isEmpty()) {
            $currentTile = $this->bag->drawFrom();

            $playPosition = $this->map->getPlayablePosition();

            $this->map->place($currentTile, $playPosition);

            echo `clear`;
            echo $currentTile->toString() . ', ' . $this->bag->getTileCount() . ' remaining.' . PHP_EOL;
            $this->map->render();
            sleep(1);
        }

        echo `clear`;
        echo 'Game Ended.' . PHP_EOL;
        $this->map->render();
    }

    /**
     * Initialise game variables
     *
     */
    private function init()
    {
        //Create and fill bag of Tiles
        $this->bag = new Bag();
        $tiles = $this->tileMapper->findAll();
        foreach($tiles as $tile) {
            $this->bag->put($tile);
        }

        //Get the starting Tile
        $startingTile = $this->bag->drawFrom();

        //Create new game map
        $this->map = new Map($startingTile);

        $this->bag->shuffle();
    }
}
