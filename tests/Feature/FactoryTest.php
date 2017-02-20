<?php

namespace Codecassonne\Feature;

use Codecassonne\Map\Coordinate;
use Codecassonne\Map\Map;
use Codecassonne\Tile\Tile;

class FactoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test Createing a feature with a tile that has no feature
     *
     * @expectedException \Codecassonne\Feature\Exception\NoFeatureFaces
     */
    public function testCreateFeatureWithNonFeatureFace()
    {
        $factory = new Factory();

        // Get North tile on a tile that has no North feature
        $factory->createFeature(
            new Coordinate(0,0),
            new Map(
                Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CLOISTER)
            ),
            'North'
        );
    }
}
