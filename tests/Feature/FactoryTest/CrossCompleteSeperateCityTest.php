<?php

namespace Codecassonne\Feature\FactoryTest;

use Codecassonne\Feature\City;
use Codecassonne\Map\Map;
use Codecassonne\Map\Coordinate;
use Codecassonne\Tile\Tile;

/**
 * A Cross Shaped City, Seperate Disconnected Cities
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
 *                                -----------  -----------  -----------
 *                                |    G    |  |    C    |  |    G    |
 *                                |         |  |         |  |         |
 * 0                              |G   G   C|  |C   G   C|  |C   G   G|
 *                                |         |  |         |  |         |
 *                                |    G    |  |    C    |  |    G    |
 *                                -----------  -----------  -----------
 *                                             -----------
 *                                             |    C    |
 *                                             |         |
 * -1                                          |G   G   G|
 *                                             |         |
 *                                             |    G    |
 *                                             -----------
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
class CrossCompleteSeperateCityTest extends CreateFeatureTest
{
    /**
     * Create a Cross City Map with features disconnected
     *
     * @return Map
     */
    private function crossCompleteCityMap()
    {
        return $this->createMap(
            [
                (new Coordinate(0, 0))->toHash()  =>
                    Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                (new Coordinate(0, 1))->toHash()  =>
                    Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                (new Coordinate(1, 0))->toHash()  =>
                    Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                (new Coordinate(0, -1))->toHash() =>
                    Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                (new Coordinate(-1, 0))->toHash() =>
                    Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
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
                $this->crossCompleteCityMap(),
                new Coordinate(0, 1),
                'South',
                2,
                true,
                City::class
            ],
            /** Test East tile, West Face */
            [
                $this->crossCompleteCityMap(),
                new Coordinate(1, 0),
                'West',
                2,
                true,
                City::class
            ],
            /** Test South tile, North Face */
            [
                $this->crossCompleteCityMap(),
                new Coordinate(0, -1),
                'North',
                2,
                true,
                City::class
            ],
            /** Test West tile, East Face */
            [
                $this->crossCompleteCityMap(),
                new Coordinate(-1, 0),
                'East',
                2,
                true,
                City::class
            ],
            /** Test Center tile, North Face */
            [
                $this->crossCompleteCityMap(),
                new Coordinate(0, 0),
                'North',
                2,
                true,
                City::class
            ],
            /** Test Center tile, East Face */
            [
                $this->crossCompleteCityMap(),
                new Coordinate(0, 0),
                'East',
                2,
                true,
                City::class
            ],
            /** Test Center tile, South Face */
            [
                $this->crossCompleteCityMap(),
                new Coordinate(0, 0),
                'South',
                2,
                true,
                City::class
            ],
            /** Test Center tile, West Face */
            [
                $this->crossCompleteCityMap(),
                new Coordinate(0, 0),
                'West',
                2,
                true,
                City::class
            ],
        ];
    }
}
