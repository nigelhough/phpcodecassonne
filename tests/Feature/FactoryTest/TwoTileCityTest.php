<?php
declare(strict_types = 1);

namespace Codecassonne\Feature\FactoryTest;

use Codecassonne\Feature\City;
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
class TwoTileCityCreation extends FeatureCreation
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
     * Data provider for feature creation test
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
                City::class
            ],
            /** Test South tile, North Face */
            [
                $this->twoTileCityMap(),
                new Coordinate(0, 0),
                'North',
                2,
                true,
                City::class
            ],
        ];
    }

    /**
     * Data Provider for features creation test
     *
     * @return array
     */
    public function featuresMapProvider()
    {
        return [
            /** Test North tile */
            [
                $this->twoTileCityMap(),
                new Coordinate(0, 1),
                1,
            ],
            /** Test South tile */
            [
                $this->twoTileCityMap(),
                new Coordinate(0, 0),
                1,
            ],
        ];
    }

    /**
     * Data Provider for cloister creation test
     *
     * @return array
     */
    public function featuresCloisterProvider()
    {
        return [
            /** Test North tile */
            [
                $this->twoTileCityMap(),
                new Coordinate(0, 1),
                0,
                0,
                0,
            ],
            /** Test South tile */
            [
                $this->twoTileCityMap(),
                new Coordinate(0, 0),
                0,
                0,
                0,
            ],
        ];
    }
}
