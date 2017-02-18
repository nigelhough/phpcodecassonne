<?php

namespace Codecassonne\Feature\FactoryTest;

use Codecassonne\Map\Map;
use Codecassonne\Map\Coordinate;
use Codecassonne\Tile\Tile;

/**
 * A Two Tile City
 *
 *          -3           -2           -1            0            1            2            3
 *
 *
 *
 * 3
 *
 *
 *
 *
 *
 *
 * 2
 *
 *
 *
 *                                             -----------
 *                                             |    G    |
 *                                             |         |
 * 1                                           |G   G   G|
 *                                             |         |
 *                                             |    C    |
 *                                             -----------
 *                                             -----------
 *                                             |    C    |
 *                                             |         |
 * 0                                           |G   G   G|
 *                                             |         |
 *                                             |    G    |
 *                                             -----------
 *
 *
 *
 * -1
 *
 *
 *
 *
 *
 *
 * -2
 *
 *
 *
 *
 *
 *
 * -3
 *
 *
 *
 *
 */
class TwoTileCityTest extends CreateFeatureTest
{
    /**
     * Create a Two Tile City Map
     *
     * @return Map
     */
    private function twoTileCityMap()
    {
        return $this->createMap(
            [
                (new Coordinate(0, 0))->toHash() =>
                    Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                (new Coordinate(0, 1))->toHash() =>
                    Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
            ]
        );
    }

    /**
     * Data provider for test
     */
    public function featureMapProvider()
    {
        return [
            /** Test North tile, South Face */
            [
                $this->twoTileCityMap(),
                new Coordinate(0, 1),
                'South',
                2,
                true,
            ],
            /** Test South tile, North Face */
            [
                $this->twoTileCityMap(),
                new Coordinate(0, 0),
                'North',
                2,
                true,
            ],
        ];
    }
}
