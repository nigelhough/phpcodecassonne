<?php
declare(strict_types = 1);

namespace Codecassonne\Feature\FactoryTest;

use Codecassonne\Map\Map;
use Codecassonne\Map\Coordinate;
use Codecassonne\Feature\Factory;
use \Codecassonne\createTestMap;

/**
 * Test for creating features
 * Extend and add data provider
 */
abstract class FeatureCreation extends \PHPUnit\Framework\TestCase
{
    use createTestMap;

    /**
     * Test Creating a Feature
     *
     * @param Map        $map               Map to create feature for
     * @param Coordinate $coordinate        Starting Coordinate to create feature from
     * @param string     $bearing           Starting Bearing to create feature from
     * @param int        $expectedTiles     Expected number of tiles in feature
     * @param bool       $expectedCompleted Expected if the feature is complete
     * @param string     $expectedClass     Expected the class tye of the featured
     * @param string[]   $sharedBearings    Any bearings on the starting coordinate not linked but shared by a looping
     *                                      feature
     *
     * @dataProvider featureMapProvider
     */
    public function testCreateFeature(
        Map $map,
        Coordinate $coordinate,
        string $bearing,
        int $expectedTiles,
        bool $expectedCompleted,
        string $expectedClass,
        array $sharedBearings = []
    ) {
        $featureFactory = new Factory();

        $feature = $featureFactory->createFeature($coordinate, $map, $bearing);

        $this->assertInstanceOf($expectedClass, $feature);
        $this->assertEquals($expectedTiles, $feature->numberOfTiles());
        $this->assertSame($expectedCompleted, $feature->isComplete());


        foreach ($sharedBearings as $sharedBearing) {
            // Check the shared bearings are part of the feature
            $this->assertTrue($feature->coordinateBearingPartOf($coordinate, $sharedBearing));
        }
    }

    /**
     * Test Creating Features
     *
     * @param Map        $map                Map to create features for
     * @param Coordinate $coordinate         Starting Coordinate to create features from
     * @param int        $expectedNoFeatures Expected number of features to find
     *
     * @dataProvider featuresMapProvider
     */
    public function testCreateFeatures(
        Map $map,
        Coordinate $coordinate,
        int $expectedNoFeatures
    ) {
        $featureFactory = new Factory();

        $features = $featureFactory->createFeatures($coordinate, $map);

        $this->assertCount($expectedNoFeatures, $features);
    }
}
