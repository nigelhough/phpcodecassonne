<?php
declare(strict_types = 1);

namespace Codecassonne\Feature;

use PHPUnit\Framework\TestCase;
use Codecassonne\Map\Coordinate;
use Codecassonne\Map\Map;

/**
 * Test for feature tile factory
 */
class FactoryTest extends TestCase
{
    /**
     * Test Creating a feature with a tile that has no feature
     *
     * @expectedException \Codecassonne\Feature\Exception\NoFeatureFaces
     */
    public function testCreateFeatureWithNonFeatureFace()
    {
        $factory = new Factory();

        // Get North tile on a tile that has no North feature
        $factory->createFeature(
            new Coordinate(0, 0),
            new Map(
                \Codecassonne\Tile\Tile::createFromString(
                    \Codecassonne\Tile\Tile::TILE_TYPE_GRASS . ":" .
                    \Codecassonne\Tile\Tile::TILE_TYPE_GRASS . ":" .
                    \Codecassonne\Tile\Tile::TILE_TYPE_GRASS . ":" .
                    \Codecassonne\Tile\Tile::TILE_TYPE_GRASS . ":" .
                    \Codecassonne\Tile\Tile::TILE_TYPE_CLOISTER
                )
            ),
            'North'
        );
    }

    /**
     * Test Creating features with a tile that has no feature
     *
     */
    public function testCreateFeaturesWithNonFeatureFace()
    {
        $factory = new Factory();

        // Get North tile on a tile that has no North feature
        $features = $factory->createFeatures(
            new Coordinate(0, 0),
            new Map(
                \Codecassonne\Tile\Tile::createFromString(
                    \Codecassonne\Tile\Tile::TILE_TYPE_GRASS . ":" .
                    \Codecassonne\Tile\Tile::TILE_TYPE_GRASS . ":" .
                    \Codecassonne\Tile\Tile::TILE_TYPE_GRASS . ":" .
                    \Codecassonne\Tile\Tile::TILE_TYPE_GRASS . ":" .
                    \Codecassonne\Tile\Tile::TILE_TYPE_GRASS
                )
            )
        );

        // No features should be returned for a tile with no feature faces
        $this->assertCount(0, $features);
    }

    /**
     * Test Creating features from an unoccupied coordinate
     *
     */
    public function testCreateFeaturesForUnoccupiedCoordinate()
    {
        $factory = new Factory();

        // Get North tile on a tile that has no North feature
        $features = $factory->createFeatures(
            new Coordinate(0, 1),
            new Map(
                \Codecassonne\Tile\Tile::createFromString(
                    \Codecassonne\Tile\Tile::TILE_TYPE_GRASS . ":" .
                    \Codecassonne\Tile\Tile::TILE_TYPE_GRASS . ":" .
                    \Codecassonne\Tile\Tile::TILE_TYPE_GRASS . ":" .
                    \Codecassonne\Tile\Tile::TILE_TYPE_GRASS . ":" .
                    \Codecassonne\Tile\Tile::TILE_TYPE_CLOISTER
                )
            )
        );

        // No features should be returned for an unoccupied coordinate
        $this->assertCount(0, $features);
    }


}
