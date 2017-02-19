<?php
declare(strict_types = 1);

namespace Codecassonne\Feature\FactoryTest;

use Codecassonne\Feature\City;
use Codecassonne\Map\Map;
use Codecassonne\Map\Coordinate;
use Codecassonne\Tile\Tile;

/**
 * A Cross Shaped City, Separate Disconnected Cities, Incomplete
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
 *                                             |    C    |
 *                                             |         |
 * 1                                           |G   C   G|
 *                                             |         |
 *                                             |    C    |
 *                                             -----------
 *                                -----------  -----------  -----------
 *                                |    G    |  |    C    |  |    G    |
 *                                |         |  |         |  |         |
 * 0                              |C   C   C|  |C   G   C|  |C   C   C|
 *                                |         |  |         |  |         |
 *                                |    G    |  |    C    |  |    G    |
 *                                -----------  -----------  -----------
 *                                             -----------
 *                                             |    C    |
 *                                             |         |
 * -1                                          |G   C   G|
 *                                             |         |
 *                                             |    C    |
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
class CrossIncompleteSeperateCityTest extends CreateFeatureTest
{
    /**
     * Create a Cross City Map with features disconnected and incomplete
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
                    Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                (new Coordinate(1, 0))->toHash()  =>
                    Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                (new Coordinate(0, -1))->toHash() =>
                    Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                (new Coordinate(-1, 0))->toHash() =>
                    Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
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
                false,
                City::class
            ],
            /** Test East tile, West Face */
            [
                $this->crossCompleteCityMap(),
                new Coordinate(1, 0),
                'West',
                2,
                false,
                City::class
            ],
            /** Test South tile, North Face */
            [
                $this->crossCompleteCityMap(),
                new Coordinate(0, -1),
                'North',
                2,
                false,
                City::class
            ],
            /** Test West tile, East Face */
            [
                $this->crossCompleteCityMap(),
                new Coordinate(-1, 0),
                'East',
                2,
                false,
                City::class
            ],
            /** Test Center tile, North Face */
            [
                $this->crossCompleteCityMap(),
                new Coordinate(0, 0),
                'North',
                2,
                false,
                City::class
            ],
            /** Test Center tile, East Face */
            [
                $this->crossCompleteCityMap(),
                new Coordinate(0, 0),
                'East',
                2,
                false,
                City::class
            ],
            /** Test Center tile, South Face */
            [
                $this->crossCompleteCityMap(),
                new Coordinate(0, 0),
                'South',
                2,
                false,
                City::class
            ],
            /** Test Center tile, West Face */
            [
                $this->crossCompleteCityMap(),
                new Coordinate(0, 0),
                'West',
                2,
                false,
                City::class
            ],
        ];
    }
}
