<?php

namespace Codecassonne\Feature;

use Codecassonne\Map\Coordinate;

/**
 * Test for Road Feature
 */
class RoadTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that a Road feature has the correct feature type and scoring value
     */
    public function testRoadValues()
    {
        // Create Dummy Feature Tile to add to Road
        $tile = $this
            ->getMockBuilder(Tile::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tile->method('getCoordinate')
            ->willReturn(new Coordinate(0,0));

        // Create dummy Road to tests
        $road = new Road(true, $tile);

        // Check the values for a Road object are correct
        $this->assertSame(\Codecassonne\Tile\Tile::TILE_TYPE_ROAD, $road->getFeatureType());
        $this->assertSame(1, $road->getTileValue());
    }
}
