<?php

namespace Codecassonne;

use Codecassonne\Map\Map;
use Codecassonne\Player\Collection as Players;
use Codecassonne\Tile\Bag;
use Codecassonne\Tile\Mapper\MapperInterface as Mapper;
use Codecassonne\Turn\Action;

/**
 * Class Game
 *
 * Pull in and execute required game elements
 */
class Game
{
    /** @var Map    The map to lay tiles on */
    private $map;

    /** @var Bag A bag to hold our Tiles */
    private $bag;

    /** @var Mapper A Mapper to get Tile Data from */
    private $tileMapper;
    /**
     * @var Players Collection of players in the game
     */
    private $players;

    /**
     * Construct the Game
     *
     * @param Mapper  $tileMapper A Mapper to get Tile Data from
     * @param Players $players    Collection of players in the game
     */
    public function __construct(Mapper $tileMapper, Players $players)
    {
        $this->tileMapper = $tileMapper;
        $this->players = $players;
    }

    /**
     * Run the game
     */
    public function run()
    {
        $this->init();
        $this->map->render(false, 400000);

        while (!$this->bag->isEmpty()) {
            $currentTile = $this->bag->drawFrom();

            $player = $this->players->next();

            try {
                $action = $player->playTurn(clone $this->map, clone $currentTile);
                if (!$action instanceof Action) {
                    throw new \Exception('Player instance must return Action');
                }
                $action->run($this->map, $currentTile);
            } catch (\Exception $e) {
                echo 'Invalid Move' . PHP_EOL;
            }

            $this->map->render(false, 400000);
        }

        $this->map->render(true);
    }

    /**
     * Initialise game variables
     */
    private function init()
    {
        //Create and fill bag of Tiles
        $this->bag = new Bag();
        $tiles = $this->tileMapper->findAll();
        foreach ($tiles as $tile) {
            $this->bag->put($tile);
        }

        //Get the starting Tile
        $startingTile = $this->bag->drawFrom();

        //Create new game map
        $this->map = new Map($startingTile);

        $this->bag->shuffle();
    }
}
