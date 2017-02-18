<?php

namespace Codecassonne\Feature\FactoryTest;

use Codecassonne\Map\Map;
use Codecassonne\Map\Coordinate;
use Codecassonne\Tile\Tile;

/**
 * A Three Tile City
 *
 *          -3           -2           -1            0            1            2            3
 *
 *
 *
 * 3
 *
 *
 *
 *                                             -----------
 *                                             |    G    |
 *                                             |         |
 * 2                                           |G   G   G|
 *                                             |         |
 *                                             |    C    |
 *                                             -----------
 *                                             -----------
 *                                             |    C    |
 *                                             |         |
 * 1                                           |G   C   G|
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
class ThreeTileCityTest extends CreateFeatureTest
{
    /**
     * Create a Three Tile City Map
     *
     * @return Map
     */
    private function threeTileCityMap()
    {
        return $this->createMap(
            [
                (new Coordinate(0, 0))->toHash() =>
                    Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                (new Coordinate(0, 1))->toHash() =>
                    Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                (new Coordinate(0, 2))->toHash() =>
                    Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
            ]
        );
    }

    /**
     * Data provider for scoring test
     */
    public function featureMapProvider()
    {
        return [
//            /** Test North tile, South Face */
//            [
//                $this->threeTileCityMap(),
//                new Coordinate(0, 2),
//                'South',
//                3,
//                true,
//            ],
            /** Test Center tile, North Face */
            [
                $this->threeTileCityMap(),
                new Coordinate(0, 1),
                'North',
                3,
                true,
            ],
            /** Test Center tile, South Face */
            [
                $this->threeTileCityMap(),
                new Coordinate(0, 1),
                'South',
                3,
                true,
            ],
//            /** Test South tile, North Face */
//            [
//                $this->threeTileCityMap(),
//                new Coordinate(0, 0),
//                'North',
//                3,
//                true,
//            ],
        ];
    }
}
