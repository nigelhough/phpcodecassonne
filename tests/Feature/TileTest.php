<?php

namespace Codecassonne\Feature;

/**
 * Test for a Feature Tile
 */
class TileTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test Accessor functions return the same values as constructed with
     */
    public function testAccessors()
    {
        // Create mock objects to pass into feature tile
        $tile = $this->getMockBuilder(\Codecassonne\Tile\Tile::class)
            ->disableOriginalConstructor()
            ->getMock();
        $coordinate = $this->getMockBuilder(\Codecassonne\Map\Coordinate::class)
            ->disableOriginalConstructor()
            ->getMock();
        $bearings = ['North', 'South', 'East', 'West'];

        // Construct a feature tile
        $featureTile = new Tile($tile, $coordinate, $bearings);

        // Assert the accessors give the same objects back
        $this->assertSame($tile, $featureTile->getTile());
        $this->assertSame($coordinate, $featureTile->getCoordinate());
        $this->assertSame($bearings, $featureTile->getBearings());
    }

    /**
     * Test a bearing is part of a feature tile
     *
     * @param array  $tileBearings   Bearings of the feature tile
     * @param string $checkBearing   Bearing to check is part of feature
     * @param bool   $expectedResult Expected result from check
     *
     * @dataProvider bearingProvider
     */
    public function testBearingPartOf(array $tileBearings, string $checkBearing, bool $expectedResult)
    {
        // Create mock objects to pass into feature tile
        $tile = $this->getMockBuilder(\Codecassonne\Tile\Tile::class)
            ->disableOriginalConstructor()
            ->getMock();
        $coordinate = $this->getMockBuilder(\Codecassonne\Map\Coordinate::class)
            ->disableOriginalConstructor()
            ->getMock();

        // Construct a feature tile
        $featureTile = new Tile($tile, $coordinate, $tileBearings);

        $this->assertSame($expectedResult, $featureTile->bearingPartOf($checkBearing));
    }

    /**
     * Data Provider for bearing part of test
     *
     * @return array
     */
    public function bearingProvider()
    {
        return [
            /** Test North Bearing when all bearings are on tile */
            [
                ['North', 'East', 'South', 'West'],
                'North',
                true,
            ],
            /** Test East Bearing when all bearings are on tile */
            [
                ['North', 'East', 'South', 'West'],
                'East',
                true,
            ],
            /** Test South Bearing when all bearings are on tile */
            [
                ['North', 'East', 'South', 'West'],
                'South',
                true,
            ],
            /** Test West Bearing when all bearings are on tile */
            [
                ['North', 'East', 'South', 'West'],
                'West',
                true,
            ],
            /** Test North Bearing when all other bearings are on tile */
            [
                ['East', 'South', 'West'],
                'North',
                false,
            ],
            /** Test North Bearing when only bearing */
            [
                ['North'],
                'North',
                true,
            ],
            /** Test North Bearing when only one other bearing */
            [
                ['South'],
                'North',
                false,
            ],
            /** Test invalid bearing, just returns false */
            [
                ['North', 'East', 'South', 'West'],
                'invalid',
                false,
            ],
            /** Test North Bearing when no bearings */
            [
                [],
                'North',
                false,
            ],
            /** Test East Bearing when no bearings */
            [
                [],
                'East',
                false,
            ],
            /** Test South Bearing when no bearings */
            [
                [],
                'South',
                false,
            ],
            /** Test West Bearing when no bearings */
            [
                [],
                'West',
                false,
            ],
        ];
    }
}
