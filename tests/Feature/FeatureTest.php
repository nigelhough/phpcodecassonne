<?php

namespace Codecassonne\Feature;

use Codecassonne\Map\Coordinate;

/**
 * Test the concrete methods in the abstract feature class
 */
class FeatureTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test the isComplete and numberOfTiles methods in a feature
     *
     * @param bool  $isComplete        If the tested feature is complete
     * @param array $tiles             The tiles in the tested feature
     * @param int   $expectedTileCount Expected result from number of tiles method
     *
     * @dataProvider featureProvider
     */
    public function testFeature(bool $isComplete, array $tiles, int $expectedTileCount)
    {
        $feature = $this->createMockFeature($isComplete, $tiles);

        $this->assertSame($isComplete, $feature->isComplete());
        $this->assertEquals($expectedTileCount, $feature->numberOfTiles());
    }

    public function featureProvider()
    {
        return [
            /** Complete feature with one tile */
            [
                true,
                [
                    $this->createMockTile(0, 0),
                ],
                1,
            ],
            /** Incomplete feature with multiple tiles */
            [
                false,
                [
                    $this->createMockTile(0, 0),
                ],
                1,
            ],
            /** Complete feature with multiple tiles */
            [
                true,
                [
                    $this->createMockTile(0, 0),
                    $this->createMockTile(0, 1),
                ],
                2,
            ],
        ];
    }

    /**
     * Test creating a feature with invalid tiles
     *
     * @expectedException \Codecassonne\Feature\Exception\DuplicateTiles
     */
    public function testInvalidTiles()
    {
        $this->createMockFeature(true, [$this->createMockTile(0, 0), $this->createMockTile(0, 0)]);
    }

    /**
     * Test if a coordinate is part of a feature
     *
     * @param array      $tiles           Tiles that are part of the feature
     * @param Coordinate $checkCoordinate Coordinate to check is part of feature
     * @param bool       $expectedResult  Expected result from check
     *
     * @dataProvider coordinateProvider
     */
    public function testCoordinatePartOf(array $tiles, Coordinate $checkCoordinate, bool $expectedResult)
    {
        $feature = $this->createMockFeature(true, $tiles);

        $this->assertSame($expectedResult, $feature->coordinatePartOf($checkCoordinate));
    }

    /**
     * Data provider for coordinate part of feature test
     *
     * @return array
     */
    public function coordinateProvider()
    {
        return [
            /** Single Coordinate feature, coordinate part of feature */
            [
                [
                    $this->createMockTile(0, 0),
                ],
                new Coordinate(0, 0),
                true,
            ],
            /** Single Coordinate feature, coordinate not part of feature */
            [
                [
                    $this->createMockTile(0, 0),
                ],
                new Coordinate(1, 0),
                false,
            ],
            /** Cross shaped feature, North coordinate part of feature */
            [
                [
                    $this->createMockTile(0, 0),
                    $this->createMockTile(0, 1),
                    $this->createMockTile(1, 0),
                    $this->createMockTile(0, -1),
                    $this->createMockTile(-1, 0),
                ],
                new Coordinate(0, 1),
                true,
            ],
            /** Cross shaped feature, East coordinate part of feature */
            [
                [
                    $this->createMockTile(0, 0),
                    $this->createMockTile(0, 1),
                    $this->createMockTile(1, 0),
                    $this->createMockTile(0, -1),
                    $this->createMockTile(-1, 0),
                ],
                new Coordinate(1, 0),
                true,
            ],
            /** Cross shaped feature, South coordinate part of feature */
            [
                [
                    $this->createMockTile(0, 0),
                    $this->createMockTile(0, 1),
                    $this->createMockTile(1, 0),
                    $this->createMockTile(0, -1),
                    $this->createMockTile(-1, 0),
                ],
                new Coordinate(0, -1),
                true,
            ],
            /** Cross shaped feature, West coordinate part of feature */
            [
                [
                    $this->createMockTile(0, 0),
                    $this->createMockTile(0, 1),
                    $this->createMockTile(1, 0),
                    $this->createMockTile(0, -1),
                    $this->createMockTile(-1, 0),
                ],
                new Coordinate(-1, 0),
                true,
            ],
            /** Cross shaped feature, North East coordinate not part of feature */
            [
                [
                    $this->createMockTile(0, 0),
                    $this->createMockTile(0, 1),
                    $this->createMockTile(1, 0),
                    $this->createMockTile(0, -1),
                    $this->createMockTile(-1, 0),
                ],
                new Coordinate(1, 1),
                false,
            ],
            /** Cross shaped feature, South East coordinate not part of feature */
            [
                [
                    $this->createMockTile(0, 0),
                    $this->createMockTile(0, 1),
                    $this->createMockTile(1, 0),
                    $this->createMockTile(0, -1),
                    $this->createMockTile(-1, 0),
                ],
                new Coordinate(1, -1),
                false,
            ],
            /** Cross shaped feature, South West coordinate not part of feature */
            [
                [
                    $this->createMockTile(0, 0),
                    $this->createMockTile(0, 1),
                    $this->createMockTile(1, 0),
                    $this->createMockTile(0, -1),
                    $this->createMockTile(-1, 0),
                ],
                new Coordinate(-1, -1),
                false,
            ],
            /** Cross shaped feature, North West coordinate not part of feature */
            [
                [
                    $this->createMockTile(0, 0),
                    $this->createMockTile(0, 1),
                    $this->createMockTile(1, 0),
                    $this->createMockTile(0, -1),
                    $this->createMockTile(-1, 0),
                ],
                new Coordinate(-1, 1),
                false,
            ],
        ];
    }

    /**
     * Test if a coordinate bearing combination is part of a feature
     *
     * @param bool $coordinatePartOf If the coordinate is part of the beature
     * @param bool $bearingPartOf    If the bearing is part of the fature tile
     * @param bool $expectedResult   Expected result from check
     *
     * @dataProvider coordinateBearingProvider
     */
    public function testCoordinateBearingPartOf(bool $coordinatePartOf, bool $bearingPartOf, $expectedResult)
    {
        $feature = $this->createMockFeature(true, [$this->createMockTile(0, 0, $bearingPartOf)]);

        // Set the check coordinate to be part of the feature or not
        $checkCoordinate = $coordinatePartOf
            ? new Coordinate(0, 0)
            : new Coordinate(1, 0);

        $this->assertSame($expectedResult, $feature->coordinateBearingPartOf($checkCoordinate, 'North'));
    }

    /**
     * Data provider for coordinate part of feature test
     *
     * @return array
     */
    public function coordinateBearingProvider()
    {
        return [
            /** Coordinate and Bearing part of feature */
            [
                true,
                true,
                true,
            ],
            /** Coordinate but not Bearing part of feature */
            [
                true,
                false,
                false,
            ],
            /** Coordinate not part of feature, bearing is meaningless */
            [
                false,
                false,
                false,
            ],
            /** Coordinate not part of feature, bearing is meaningless but test both */
            [
                false,
                true,
                false,
            ],
        ];
    }

    /**
     * Create a mock feature
     *
     * @param bool  $isComplete        If the tested feature is complete
     * @param array $tiles             The tiles in the tested feature
     *
     * @return Feature
     */
    private function createMockFeature(bool $isComplete, array $tiles)
    {
        $arguments = [];
        $arguments[] = $isComplete;
        $arguments = array_merge($arguments, $tiles);
        return $this->getMockForAbstractClass(Feature::class, $arguments);
    }

    /**
     * Create a mock feature tile
     *
     * @param int  $xCoord        X coordinate tile is on feature
     * @param int  $yCoord        Y coordinate tile is on feature
     * @param bool $bearingPartOf Mock response from bearing part of function
     *
     * @return Tile
     */
    private function createMockTile(int $xCoord, int $yCoord, bool $bearingPartOf = true)
    {
        $tile = $this->getMockBuilder(Tile::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tile->method('getCoordinate')
            ->willReturn(new Coordinate($xCoord, $yCoord));
        $tile->method('bearingPartOf')
            ->willReturn($bearingPartOf);

        return $tile;
    }
}
