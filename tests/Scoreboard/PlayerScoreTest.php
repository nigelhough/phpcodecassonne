<?php
declare(strict_types = 1);

namespace Codecassonne\Scoreboard;

use PHPUnit\Framework\TestCase;
use Codecassonne\Player\PlayerInterface;

/**
 * Test a Player Score
 */
class PlayerScoreTest extends TestCase
{
    /**
     * Test a Player Score
     * Tests Constructor, Accessors and Mutator
     *
     * @param PlayerInterface $player        Player to
     * @param array           $scores        List of values to add to players score
     * @param int             $expectedTotal Expected Total Score for Player
     *
     * @dataProvider playerScoreProvider
     */
    public function testPlayerScore(PlayerInterface $player, array $scores, $expectedTotal)
    {
        $playerScore = new PlayerScore($player);

        $this->assertSame($player, $playerScore->getPlayer());

        $expectedScore = 0;
        $this->assertEquals($expectedScore, $playerScore->getScore());

        foreach ($scores as $score) {
            $playerScore->incrementScore($score);
            $expectedScore += $score;
            $this->assertEquals($expectedScore, $playerScore->getScore());
        }

        $this->assertEquals($expectedTotal, $playerScore->getScore());
    }

    /**
     * Data Provider for Player Score test
     *
     * @return array
     */
    public function playerScoreProvider()
    {
        $player = $this->createMockPlayer();
        return [
            /** No Scores */
            [
                $player,
                [],
                0,
            ],
            /** A Scores */
            [
                $player,
                [5],
                5,
            ],
            /** Multiple Scores */
            [
                $player,
                [1, 2, 3, 5, 8, 13, 21],
                53,
            ],
        ];
    }

    /**
     * Test incrementing a players score with an invalid score
     *
     * @param int $score Invalid value to increment score by
     *
     * @expectedException \Codecassonne\Scoreboard\Exception\InvalidScore
     *
     * @dataProvider invalidScoreProvider
     */
    public function testInvalidScore($score)
    {
        $playerScore = new PlayerScore($this->createMockPlayer());
        $playerScore->incrementScore($score);
    }

    /**
     * Data Provider for Player Score test
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
