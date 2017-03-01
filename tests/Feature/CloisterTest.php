<?php

namespace Codecassonne\Feature;

use Codecassonne\Map\Coordinate;

/**
 * Test for Cloister Feature
 */
class CloisterTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test that a Cloister feature has the correct feature type and scoring value
     */
    public function testCloisterValues()
    {
        // Create Dummy Feature Tile to add to Cloister
        $tile = $this
            ->getMockBuilder(Tile::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tile->method('getCoordinate')
            ->willReturn(new Coordinate(0,0));

        // Create dummy Cloister to tests
        $cloister = new Cloister(true, $tile);

        // Check the values for a Cloister object are correct
        $this->assertSame(\Codecassonne\Tile\Tile::TILE_TYPE_CLOISTER, $cloister->getFeatureType());
        $this->assertSame(1, $cloister->getTileValue());
    }
}