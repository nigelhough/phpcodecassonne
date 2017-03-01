<?php

//Autoload application
require dirname(__DIR__) . '/vendor/autoload.php';

//Create Tile Mapper
$mapper = new \Codecassonne\Tile\Mapper\File(dirname(__DIR__) . '/tiles.ini');

//Initialise Game and Run It
$players = new \Codecassonne\Player\Collection(
    new \Codecassonne\Player\Marvin(),
    new \Codecassonne\Player\Kryten()
);

// Construct Scoring Service and Game Scoreboard
$scoreboard = new Codecassonne\Scoreboard\Scoreboard($players);
$scoringService = new Codecassonne\Scoring\Service;

$game = new Codecassonne\Game($mapper, $players, $scoringService, $scoreboard);
$game->run();
