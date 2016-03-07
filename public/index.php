<?php

//Autoload application
require dirname(__DIR__) . '/vendor/autoload.php';

//Create Tile Mapper
$mapper = new \Codecassonne\Tile\Mapper\File(dirname(__DIR__) . '/tiles.ini');

//Initialise Game and Run It
$players = new \Codecassonne\Player\Collection(
    new \Codecassonne\Player\Marvin
);

$game = new Codecassonne\Game($mapper, $players);
$game->run();
