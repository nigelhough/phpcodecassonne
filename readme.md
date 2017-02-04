# PHPCodecassonne
## Introduction
A PHP project inspired by the board game Carcassonne

See the board game here [http://www.zmangames.com/carcassonne-universe.html]

The project is a framework to allow developers to design and build their own AIs that become players in the board game.

The aim is to have competative gameplay that is fun and helps people learn PHP 

## How to play
To start create a player that implements `Codecassonne\Player\PlayerInterface`

Add your player to the `$players` array in `public/index.php`

Start the PHP Web Server `php -S localhost:8000 -t public/`

Open your browser to `http://localhost:8000/` and see game your AI play again

You can also play on the command line `php public/index.php`
 
## AI Goal
The goal for your AI is to place all the pieces and build a map
 
## Development
The project is being built MVP (Minimum Viable Product)

Only the basic game has been implemented so far, the game will draw all tiles from a bag iterate over players for the players to make a move, producing a map of features

## In-Development
Upcoming is a scoring service so you can create an AI that scores the most points

See the development roadmap online here [https://trello.com/b/IuymIjg7/phpcodecassonne]

## Be involved
Fork the project to create a player, add functionality or fix a bug

To join in conversations on the project request to join our Slack chat group [https://phpcodecassonne.slack.com]
