# PHPCodecassonne
[![GitHub version](https://badge.fury.io/gh/nigelhough%2Fphpcodecassonne.svg)](https://badge.fury.io/gh/nigelhough%2Fphpcodecassonne)
[![Build Status](https://travis-ci.org/nigelhough/phpcodecassonne.svg?branch=master)](https://travis-ci.org/nigelhough/phpcodecassonne)
[![codecov](https://codecov.io/gh/nigelhough/phpcodecassonne/branch/master/graph/badge.svg)](https://codecov.io/gh/nigelhough/phpcodecassonne)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nigelhough/phpcodecassonne/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/nigelhough/phpcodecassonne/?branch=master)
[![Code Climate](https://codeclimate.com/github/nigelhough/phpcodecassonne/badges/gpa.svg)](https://codeclimate.com/github/nigelhough/phpcodecassonne)
[![Dependency Status](https://www.versioneye.com/user/projects/58a6fb71b4d2a20036950dd0/badge.svg?style=flat-square)](https://www.versioneye.com/user/projects/58a6fb71b4d2a20036950dd0)
[![PHPStan](https://img.shields.io/badge/PHPStan-enabled-brightgreen.svg?style=flat)](https://github.com/phpstan/phpstan)

## Introduction
A PHP project inspired by the board game Carcassonne.

See the board game here [http://www.zmangames.com/carcassonne-universe.html].

The project is a framework to allow developers to design and build their own AIs that become players in the board game.

The aim is to have competitive game play that is fun and helps people learn PHP.

## How to play
To start create a player that extends the abstract `Codecassonne\Player\Player` or implements `Codecassonne\Player\PlayerInterface`.

To test your player add them to the list in `\Codecassonne\Player\PlayerTest` `getPlayers()`.
To play a game with your player add them to the `$players` array in `public/index.php`.

Start the PHP Web Server `php -S localhost:8000 -t public/`.

Open your browser to `http://localhost:8000/` and see your AI play a game.

You can also play on the command line `php public/index.php`.
 
## AI Goal
The goal is to create a player AI that can play moves to build a complete map.

By completing features your player will score points.

Try seeing if you can build an AI that can score more points than Marvin and if you can do that try taking on Kryten.

Any created Players should pass all Player Unit tests in `\Codecassonne\Player\PlayerTest`.

## Development
The project is being built MVP (Minimum Viable Product).

Only the basic game has been implemented so far

* The game will draw all tiles from a bag iterate over players for the players to make a move, producing a map of features
* Complete features will be scored after each player's move, if a player completes a feature they score the points

## In-Development
Upcoming is player Meeples so players can claim incomplete features.

See the development road map online here [https://trello.com/b/IuymIjg7/phpcodecassonne].

## Be involved
Fork the project to create a player, add functionality or fix a bug.

Please ensure all changes pass the existing build process and don't have a negative impact on code quality.

To join in conversations on the project request to join our Slack chat group [https://phpcodecassonne.slack.com].
