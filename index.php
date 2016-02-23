<?php

//Autoload application
require __DIR__ . '/vendor/autoload.php';

//Create Tile Mapper
$mapper = new \Codecassonne\Tile\Mapper(__DIR__ . '/tiles.ini');

//Initialise Game and Run It
$game = new Codecassonne\Game($mapper);
$game->run();