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
     * @param $map
     * @param $coordinate
     * @param $bearing
     * @param $expectedTiles
     *
     * @dataProvider featureMapProvider
     */
    public function testCreateFeature(
        Map $map,
        Coordinate $coordinate,
        string $bearing,
        int $expectedTiles,
        bool $expectedCompleted
    ) {
        $featureFactory = new Factory();

        $feature = $featureFactory->createFeature($coordinate, $map, $bearing);

        $this->assertEquals($expectedTiles, $feature->numberOfTiles());
        $this->assertSame($expectedCompleted, $feature->isComplete());
    }
}
