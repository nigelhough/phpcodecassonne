<?php

namespace Codecassonne\Feature\FactoryTest;

use Codecassonne\Map\Map;
use Codecassonne\Map\Coordinate;
use Codecassonne\Tile\Tile;
use Codecassonne\Feature\Factory;

/**
 * Test for creating features
 * Extend and add data provider
 */
abstract class CreateFeatureTest extends \PHPUnit_Framework_TestCase
{
    use \Codecassonne\createTestMap;

    /**
     * Test Creating a Feature
     *
     * @param $map                  Map to create feature for
     * @param $coordinate           Starting Coordinate to create feature from
     * @param $bearing              Strating Bearing to create feature from
     * @param $expectedTiles        Expected number of tiles in feature
     * @param $expectedCompleted    Expected if the feature is complete
     * @param $expectedClass        Expected the class tye of the featur
     *
     * @dataProvider featureMapProvider
     */
    public function testCreateFeature(
        Map $map,
        Coordinate $coordinate,
        string $bearing,
        int $expectedTiles,
        bool $expectedCompleted,
        string $expectedClass
    ) {
        $featureFactory = new Factory();

        $feature = $featureFactory->createFeature($coordinate, $map, $bearing);

        $this->assertInstanceOf($expectedClass, $feature);
        $this->assertEquals($expectedTiles, $feature->numberOfTiles());
        $this->assertSame($expectedCompleted, $feature->isComplete());

        // @todo Test the feature faces are correct
        // When a tile has two disconnected faces connected to the same feature are they both in the feature object
        // Seperate Test?
    }
}
