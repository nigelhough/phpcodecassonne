<?php

namespace Codecassonne\Feature;

use Codecassonne\Map\Coordinate;

/**
 * Test for City Feature
 */
class CityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that a City feature has the correct feature type and scoring value
     */
    public function testCityValues()
    {
        // Create Dummy Feature Tile to add to City
        $tile = $this
            ->getMockBuilder(Tile::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tile->method('getCoordinate')
            ->willReturn(new Coordinate(0,0));

        // Create dummy City to tests
        $city = new City(true, $tile);

        // Check the values for a City object are correct
        $this->assertSame(\Codecassonne\Tile\Tile::TILE_TYPE_CITY, $city->getFeatureType());
        $this->assertSame(2, $city->getTileValue());
    }
}
