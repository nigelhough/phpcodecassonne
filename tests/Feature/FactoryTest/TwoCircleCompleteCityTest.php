<?php
declare(strict_types = 1);

namespace Codecassonne\Feature\FactoryTest;

use Codecassonne\Feature\City;
use Codecassonne\Map\Map;
use Codecassonne\Map\Coordinate;
use Codecassonne\Tile\Tile;

/**
 * Two Circle Cities Complete and Connected
 *
 *         -3           -2           -1            0            1            2            3
 *
 *
 *
 *3
 *
 *
 *
 *
 *
 *
 *2
 *
 *
 *
 *                               -----------  -----------
 *                               |    G    |  |    G    |
 *                               |         |  |         |
 *1                              |G   C   C|  |C   C   G|
 *                               |         |  |         |
 *                               |    C    |  |    C    |
 *                               -----------  -----------
 *                               -----------  -----------  -----------
 *                               |    C    |  |    C    |  |    G    |
 *                               |         |  |         |  |         |
 *0                              |G   C   C|  |C   G   C|  |C   C   G|
 *                               |         |  |         |  |         |
 *                               |    G    |  |    C    |  |    C    |
 *                               -----------  -----------  -----------
 *                                            -----------  -----------
 *                                            |    C    |  |    C    |
 *                                            |         |  |         |
 *-1                                          |G   C   C|  |C   C   G|
 *                                            |         |  |         |
 *                                            |    G    |  |    G    |
 *                                            -----------  -----------
 *
 *
 *
 *-2
 *
 *
 *
 *
 *
 *
 *-3
 *
 *
 *
 *

 */
class TwoCircleCompleteCityCreation extends FeatureCreation
{
    /**
     * Create a map of two circle cities connected
     *
     * @return Map
     */
    private function twoCircleCompleteCityMap()
    {
        return $this->createMap(
            [
                (new Coordinate(0, 0))->toHash()   =>
                    Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                (new Coordinate(0, 1))->toHash()   =>
                    Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                (new Coordinate(1, 0))->toHash()   =>
                    Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                (new Coordinate(1, -1))->toHash()  =>
                    Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                (new Coordinate(0, -1))->toHash()  =>
                    Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                (new Coordinate(-1, 0))->toHash()  =>
                    Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                (new Coordinate(-1, 1))->toHash()  =>
                    Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
            ]
        );
    }

    /**
     * Data provider for feature creation test
     */
    public function featureMapProvider()
    {
        return [
            /** Test North West tile, East Face */
            [
                $this->twoCircleCompleteCityMap(),
                new Coordinate(-1, 1),
                'East',
                4,
                true,
                City::class,
            ],
            /** Test North West tile, South Face */
            [
                $this->twoCircleCompleteCityMap(),
                new Coordinate(-1, 1),
                'South',
                4,
                true,
                City::class,
            ],
            /** Test North tile, South Face */
            [
                $this->twoCircleCompleteCityMap(),
                new Coordinate(0, 1),
                'South',
                4,
                true,
                City::class,
            ],
            /** Test North tile, West Face */
            [
                $this->twoCircleCompleteCityMap(),
                new Coordinate(0, 1),
                'West',
                4,
                true,
                City::class,
            ],
            /** Test West tile, North Face */
            [
                $this->twoCircleCompleteCityMap(),
                new Coordinate(-1, 0),
                'North',
                4,
                true,
                City::class,
            ],
            /** Test West tile, East Face */
            [
                $this->twoCircleCompleteCityMap(),
                new Coordinate(-1, 0),
                'East',
                4,
                true,
                City::class,
            ],
            /** Test Center tile, North Face */
            [
                $this->twoCircleCompleteCityMap(),
                new Coordinate(0, 0),
                'North',
                4,
                true,
                City::class,
                ['West'],
            ],
            /** Test Center tile, East Face */
            [
                $this->twoCircleCompleteCityMap(),
                new Coordinate(0, 0),
                'East',
                4,
                true,
                City::class,
                ['South']
            ],
            /** Test Center tile, South Face */
            [
                $this->twoCircleCompleteCityMap(),
                new Coordinate(0, 0),
                'South',
                4,
                true,
                City::class,
                ['East']
            ],
            /** Test Center tile, West Face */
            [
                $this->twoCircleCompleteCityMap(),
                new Coordinate(0, 0),
                'West',
                4,
                true,
                City::class,
                ['North']
            ],
            /** Test East tile, South Face */
            [
                $this->twoCircleCompleteCityMap(),
                new Coordinate(1, 0),
                'South',
                4,
                true,
                City::class,
            ],
            /** Test East tile, West Face */
            [
                $this->twoCircleCompleteCityMap(),
                new Coordinate(1, 0),
                'West',
                4,
                true,
                City::class,
            ],
            /** Test South tile, North Face */
            [
                $this->twoCircleCompleteCityMap(),
                new Coordinate(0, -1),
                'North',
                4,
                true,
                City::class,
            ],
            /** Test South tile, East Face */
            [
                $this->twoCircleCompleteCityMap(),
                new Coordinate(0, -1),
                'East',
                4,
                true,
                City::class,
            ],
            /** Test South East tile, North Face */
            [
                $this->twoCircleCompleteCityMap(),
                new Coordinate(1, -1),
                'North',
                4,
                true,
                City::class,
            ],
            /** Test South East tile, West Face */
            [
                $this->twoCircleCompleteCityMap(),
                new Coordinate(1, -1),
                'West',
                4,
                true,
                City::class,
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
            /** Test North West tile */
            [
                $this->twoCircleCompleteCityMap(),
                new Coordinate(-1, 1),
                1,
            ],
            /** Test North tile */
            [
                $this->twoCircleCompleteCityMap(),
                new Coordinate(0, 1),
                1,
            ],
            /** Test West tile */
            [
                $this->twoCircleCompleteCityMap(),
                new Coordinate(-1, 0),
                1,
            ],
            /** Test Center tile */
            [
                $this->twoCircleCompleteCityMap(),
                new Coordinate(0, 0),
                2,
            ],
            /** Test East tile */
            [
                $this->twoCircleCompleteCityMap(),
                new Coordinate(1, 0),
                1,
            ],
            /** Test South West tile */
            [
                $this->twoCircleCompleteCityMap(),
                new Coordinate(0, -1),
                1,
            ],
            /** Test South East tile */
            [
                $this->twoCircleCompleteCityMap(),
                new Coordinate(1, -1),
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
            /** Test North West tile */
            [
                $this->twoCircleCompleteCityMap(),
                new Coordinate(-1, 1),
                0,
                0,
                0,
            ],
            /** Test North tile */
            [
                $this->twoCircleCompleteCityMap(),
                new Coordinate(0, 1),
                0,
                0,
                0,
            ],
            /** Test West tile */
            [
                $this->twoCircleCompleteCityMap(),
                new Coordinate(-1, 0),
                0,
                0,
                0,
            ],
            /** Test Center tile */
            [
                $this->twoCircleCompleteCityMap(),
                new Coordinate(0, 0),
                0,
                0,
                0,
            ],
            /** Test East tile */
            [
                $this->twoCircleCompleteCityMap(),
                new Coordinate(1, 0),
                0,
                0,
                0,
            ],
            /** Test South West tile */
            [
                $this->twoCircleCompleteCityMap(),
                new Coordinate(0, -1),
                0,
                0,
                0,
            ],
            /** Test South East tile */
            [
                $this->twoCircleCompleteCityMap(),
                new Coordinate(1, -1),
                0,
                0,
                0,
            ],
        ];
    }
}
