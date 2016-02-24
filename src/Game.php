<?php

namespace Codecassonne;
use Codecassonne\Map\Map;
use Codecassonne\Tile\Bag;
use Codecassonne\Tile\Mapper\MapperInterface as Mapper;
use Codecassonne\Map\Coordinate;

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
        $xCoord = 0;
        $yCoord = 1;
        while (!$this->bag->isEmpty()) {
            $currentTile = $this->bag->drawFrom();

            $this->map->place($currentTile, new Coordinate($xCoord, $yCoord));
            if (rand(1, 10)%2 == 0) {
                $xCoord++;
            } else {
                $yCoord++;
            }
            echo $currentTile->toString() . ', ' . $this->bag->getTileCount() . ' remaining.' . PHP_EOL;
        }
        $this->map->render();
    }

    /**
     * Initialise game variables
     *
     */
    private function init()
    {
        $this->map = new Map();
        $this->bag = new Bag();

        $tiles = $this->tileMapper->findAll();

        foreach($tiles as $tile) {
            $this->bag->put($tile);
        }

        $this->bag->shuffle();
    }
}
