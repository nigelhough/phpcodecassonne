<?php

namespace Codecassonne\Turn;

use Codecassonne\Map\Coordinate;

class ActionTest extends \PHPUnit_Framework_TestCase
{
    public function testRun()
    {
        $rotation = 90;

        $action = new Action(new Coordinate(0, 0), $rotation);

        $tile = $this->getMock('\Codecassonne\Tile\Tile');
        $tile->expects($this->once())
            ->method('rotateTo')
            ->with($rotation);

        $map = $this->getMockBuilder('\Codecassonne\Map\Map')->disableOriginalConstructor()
            ->getMock();
        $map->expects($this->once())->method('place');

        $action->run($map, $tile);
    }
}
