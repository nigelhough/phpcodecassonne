<?php
declare(strict_types = 1);

namespace Codecassonne\Turn;

use PHPUnit\Framework\TestCase;
use Codecassonne\Map\Coordinate;
use Codecassonne\Map\Map;
use Codecassonne\Tile\Tile;
use Codecassonne\Scoring;

/**
 * Test a Player Action
 */
class ActionTest extends TestCase
{
    /**
     * Test running an Action
     * Could create real Maps and Tiles to test and not Mocks?
     */
    public function testRun()
    {
        $rotation = 90;

        $action = new Action(new Coordinate(0, 0), $rotation);

        // Mock a tile
        $tile = $this->getMockBuilder(Tile::class)
            ->disableOriginalConstructor()->getMock();
        $tile->expects($this->once())
            ->method('rotateTo')
            ->with($rotation);

        // Mock a Map
        $map = $this->getMockBuilder(Map::class)->disableOriginalConstructor()
            ->getMock();
        $map->expects($this->once())->method('place');

        $action->run($map, $tile);
    }

    /**
     * Test scoring an action
     * Ensure score returned is what the scoring service calculated
     */
    public function testScoring()
    {
        $action = new Action(new Coordinate(0, 0), 90);

        // Mock a Map
        $map = $this->getMockBuilder(Map::class)->disableOriginalConstructor()
            ->getMock();

        // Mock Scoring Service
        $scoring = $this->getMockBuilder(Scoring\Service::class)->disableOriginalConstructor()
            ->getMock();
        $scoring->expects($this->once())
            ->method('calculateScore')
            ->willReturn(10);

        $this->assertEquals(10, $action->score($map, $scoring));
    }
}
