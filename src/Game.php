<?php
declare(strict_types = 1);
namespace Codecassonne;

use Codecassonne\Map\Map;
use Codecassonne\Player\Collection as Players;
use Codecassonne\Tile\Bag;
use Codecassonne\Tile\Mapper\MapperInterface as Mapper;
use Codecassonne\Turn\Action;
use Codecassonne\Scoring;
use Codecassonne\Scoreboard\Scoreboard;
use Codecassonne\Scoreboard\PlayerScore;

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

    /** @var Players Collection of players in the game */
    private $players;

    /** @var Scoring\Service Service for scoring a game */
    private $scoring;

    /** @var Scoreboard Game scoreboard */
    private $scoreboard;

    /**
     * Construct the Game
     *
     * @param Mapper          $tileMapper A Mapper to get Tile Data from
     * @param Players         $players    Collection of players in the game
     * @param Scoring\Service $scoring    Service for scoring a game
     * @param Scoreboard      $scoreboard Game Scoreboard
     */
    public function __construct(Mapper $tileMapper, Players $players, Scoring\Service $scoring, Scoreboard $scoreboard)
    {
        $this->tileMapper = $tileMapper;
        $this->players = $players;
        $this->scoring = $scoring;
        $this->scoreboard = $scoreboard;
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

                // Score action taken by player
                $score = $action->score($this->map, $this->scoring);
                if ($score > 0) {
                    $playerScore = new PlayerScore($player, $score);

                    // Add score to scoreboard
                    $this->scoreboard->addPlayerScore($playerScore);
                }
            } catch (\Exception $e) {
                echo 'Invalid Move' . PHP_EOL;
            }

            $this->map->render(false, 400000);
        }

        $this->map->render(true);
        $this->scoreboard->render();
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
