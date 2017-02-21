<?php
declare(strict_types=1);

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
}
