<?php
declare(strict_types = 1);

namespace Codecassonne\Scoreboard;

use PHPUnit\Framework\TestCase;
use Codecassonne\Player\PlayerInterface;
use Codecassonne\Player\Collection;

/**
 * Tests for a Scoreboard
 */
class ScoreboardTest extends TestCase
{
    /**
     * Test adding a series of scores for players and then getting their overall score
     *
     * @param int[] $scores
     * @param int   $expectedScore
     *
     * @dataProvider playerScoreProvider
     */
    public function testPlayerScores(array $scores, int $expectedScore)
    {
        // Create a scoreboard with valid player(s)
        $player1 = $this->createMockPlayer();
        $player2 = $this->createMockPlayer();
        $player3 = $this->createMockPlayer();
        $collection = new Collection($player1, $player2, $player3);
        $scoreboard = new Scoreboard($collection);

        // Add a Series of scores to the players
        foreach ($scores as $score) {
            $scoreboard->addPlayerScore(new PlayerScore($player1, $score));
            $scoreboard->addPlayerScore(new PlayerScore($player2, ($score * 2)));
            $scoreboard->addPlayerScore(new PlayerScore($player3, ($score * 3)));
        }

        // Assert Player and Scores are Expected
        $playerScore = $scoreboard->getPlayerScore($player1);
        $this->assertSame($player1, $playerScore->getPlayer());
        $this->assertSame($expectedScore, $playerScore->getScore());

        $playerScore = $scoreboard->getPlayerScore($player2);
        $this->assertSame($player2, $playerScore->getPlayer());
        $this->assertSame(($expectedScore * 2), $playerScore->getScore());

        $playerScore = $scoreboard->getPlayerScore($player3);
        $this->assertSame($player3, $playerScore->getPlayer());
        $this->assertSame(($expectedScore * 3), $playerScore->getScore());
    }

    /**
     * Data Provider for Player Score test
     *
     * @return array
     */
    public function playerScoreProvider()
    {
        return [
            /** No Scores */
            [
                [],
                0,
            ],
            /** A Scores */
            [
                [5],
                5,
            ],
            /** Multiple Scores */
            [
                [1, 2, 3, 5, 8, 13, 21],
                53,
            ],
        ];
    }

    /**
     * Test adding a score to a player with an invalid score
     *
     * @param $score
     *
     * @dataProvider invalidScoreProvider
     * @expectedException \Codecassonne\Scoreboard\Exception\InvalidScore
     */
    public function testAddingInvalidScore($score)
    {
        // Create a scoreboard with valid player(s)
        $player1 = $this->createMockPlayer();
        $collection = new Collection($player1);
        $scoreboard = new Scoreboard($collection);

        $scoreboard->addPlayerScore(new PlayerScore($player1, $score));
    }

    /**
     * Data Provider for invalid score adding test
     *
     * @return array
     */
    public function invalidScoreProvider()
    {
        return [
            /** 0 Score */
            [0],
            /** Negative Score */
            [-1],
        ];
    }

    /**
     * Test adding a score to a player not on the scoreboard
     *
     * @expectedException \Codecassonne\Scoreboard\Exception\InvalidPlayer
     */
    public function testAddingScoreToInvalidPlayer()
    {
        // Create a scoreboard with valid player(s)
        $player1 = $this->createMockPlayer();
        $player2 = $this->createMockPlayer();
        $collection = new Collection($player1);
        $scoreboard = new Scoreboard($collection);

        $scoreboard->addPlayerScore(new PlayerScore($player2, 84));
    }

    /**
     * Test getting a score for a player not on the scoreboard
     *
     * @expectedException \Codecassonne\Scoreboard\Exception\InvalidPlayer
     */
    public function testGetInvalidPlayerScore()
    {
        // Create a scoreboard with valid player(s)
        $player1 = $this->createMockPlayer();
        $player2 = $this->createMockPlayer();
        $collection = new Collection($player1);
        $scoreboard = new Scoreboard($collection);

        $scoreboard->getPlayerScore($player2);
    }

    /**
     * Create a mock player
     *
     * @return PlayerInterface
     */
    private function createMockPlayer()
    {
        return $this
            ->getMockBuilder(PlayerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
    }
}
