<?php
declare(strict_types = 1);

namespace Codecassonne\Scoreboard;

use Codecassonne\Player\PlayerInterface;
use Codecassonne\Scoreboard\Exception\InvalidPlayer;
use Codecassonne\Player\Collection;

/**
 * A Scoreboard to keep track of Players scores
 */
class Scoreboard
{
    /** @var \Codecassonne\Scoreboard\PlayerScore[] A collection of Player Scores */
    private $playerScores;

    /**
     * Scoreboard constructor.
     *
     * @param \Codecassonne\Player\Collection $players Players to track scores for
     */
    public function __construct(Collection $players)
    {
        // Create Player Scores for all the Players
        for ($i = 0; $i < $players->count(); $i++) {
            $player = $players->next();
            $this->playerScores[spl_object_hash($player)] = new PlayerScore($player);
        }
    }

    /**
     * Get a score for a particular player
     *
     * @param PlayerInterface $player Player to get score for
     *
     * @return PlayerScore
     * @throws InvalidPlayer
     */
    public function getPlayerScore(PlayerInterface $player)
    {
        $key = spl_object_hash($player);
        if (!array_key_exists($key, $this->playerScores)) {
            throw new InvalidPlayer('Can\'t get a score for a player not on the scoreboard');
        }

        // Clone so player score can't be altered
        return clone $this->playerScores[$key];
    }

    /**
     * Add a score for a particular player
     *
     * @param PlayerScore $playerScore Player and score to increment existing score by
     *
     * @return void
     * @throws InvalidPlayer
     */
    public function addPlayerScore(PlayerScore $playerScore)
    {
        $player = $playerScore->getPlayer();
        $key = spl_object_hash($player);
        if (!array_key_exists($key, $this->playerScores)) {
            throw new InvalidPlayer('Can\'t get a score for a player not on the scoreboard');
        }

        $this->playerScores[$key]->incrementScore($playerScore->getScore());
    }

    /**
     * Render Scoreboard
     *
     * @todo Move all of the Render code for this, game and map into views and render classes
     */
    public function render()
    {
        if (php_sapi_name() == "cli") {
            $this->renderCli();
        }

        $this->renderWeb();
    }

    /**
     * Render Scoreboard for the CLI
     */
    private function renderCli()
    {
        foreach ($this->playerScores as $playerScore) {
            echo $playerScore->getPlayer()->getName() . " > " . $playerScore->getScore() . PHP_EOL;
        }
    }

    /**
     * Render Scoreboard for the web
     */
    private function renderWeb()
    {
        echo "<table class='scoreboard' border='1'>";
        echo "<thead><tr><th>Player</th><th>Score</th></tr></thead><tbody>";
        foreach ($this->playerScores as $playerScore) {
            echo "<tr><td>"
                . $playerScore->getPlayer()->getName()
                . "</td><td>"
                . $playerScore->getScore()
                . "</td></tr>";
        }
        echo "</tbody></table>";
    }
}
