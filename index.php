<?php

//Autoload application
require __DIR__ . '/vendor/autoload.php';

$game = new Codecassonne\Game();
$game->run();