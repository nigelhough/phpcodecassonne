<?php
declare(strict_types = 1);

namespace Codecassonne\Feature\FactoryTest;

use Codecassonne\Feature\Road;
use Codecassonne\Feature\City;
use Codecassonne\Map\Map;
use Codecassonne\Map\Coordinate;
use Codecassonne\Tile\Tile;

/**
 * A Circle Complete City with a disconnected corner
 * Surrounded by some incomplete roads to give coverage
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
 *                                -----------  -----------  -----------
 *                                |    R    |  |    R    |  |    R    |
 *                                |         |  |         |  |         |
 * 1                              |R   R   C|  |C   C   C|  |C   C   R|
 *                                |         |  |         |  |         |
 *                                |    C    |  |    R    |  |    C    |
 *                                -----------  -----------  -----------
 *                                -----------               -----------
 *                                |    C    |               |    C    |
 *                                |         |               |         |
 * 0                              |R   C   R|               |R   C   R|
 *                                |         |               |         |
 *                                |    C    |               |    C    |
 *                                -----------  -----------  -----------
 *                                -----------  -----------  -----------
 *                                |    C    |  |    R    |  |    C    |
 *                                |         |  |         |  |         |
 * -1                             |R   C   C|  |C   C   C|  |C   C   R|
 *                                |         |  |         |  |         |
 *                                |    R    |  |    R    |  |    R    |
 *                                -----------  -----------  -----------
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
class CircleCompleteCityDisconnectedCornerTest extends CreateFeatureTest
{
    /**
     * Create a square complete city
     *
     * @return Map
     */
    private function circleCompleteCityDisconnectedCornerMap()
    {
        return $this->createMap(
            [
                (new Coordinate(0, 1))->toHash()   =>
                    Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                (new Coordinate(1, 1))->toHash()   =>
                    Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                (new Coordinate(1, 0))->toHash()   =>
                    Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY),
                (new Coordinate(1, -1))->toHash()  =>
                    Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                (new Coordinate(0, -1))->toHash()  =>
                    Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                (new Coordinate(-1, -1))->toHash() =>
                    Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY),
                (new Coordinate(-1, 0))->toHash()  =>
                    Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY),
                (new Coordinate(-1, 1))->toHash()  =>
                    Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD),
            ]
        );
    }

    /**
     * Data provider for feature creation test
     */
    public function featureMapProvider()
    {
        return [
            /** Test North West tile, North Face */
            [
                $this->circleCompleteCityDisconnectedCornerMap(),
                new Coordinate(-1, 1),
                'North',
                1,
                false,
                Road::class,
            ],
            /** Test North West tile, East Face */
            [
                $this->circleCompleteCityDisconnectedCornerMap(),
                new Coordinate(-1, 1),
                'East',
                8,
                true,
                City::class,
                ['South']
            ],
            /** Test North West tile, South Face */
            [
                $this->circleCompleteCityDisconnectedCornerMap(),
                new Coordinate(-1, 1),
                'South',
                8,
                true,
                City::class,
                ['East']
            ],
            /** Test North West tile, West Face */
            [
                $this->circleCompleteCityDisconnectedCornerMap(),
                new Coordinate(-1, 1),
                'West',
                1,
                false,
                Road::class,
            ],
            /** Test North tile, North Face */
            [
                $this->circleCompleteCityDisconnectedCornerMap(),
                new Coordinate(0, 1),
                'North',
                1,
                false,
                Road::class,
            ],
            /** Test North tile, East Face */
            [
                $this->circleCompleteCityDisconnectedCornerMap(),
                new Coordinate(0, 1),
                'East',
                8,
                true,
                City::class,
            ],
            /** Test North tile, South Face */
            [
                $this->circleCompleteCityDisconnectedCornerMap(),
                new Coordinate(0, 1),
                'South',
                1,
                false,
                Road::class,
            ],
            /** Test North tile, West Face */
            [
                $this->circleCompleteCityDisconnectedCornerMap(),
                new Coordinate(0, 1),
                'West',
                8,
                true,
                City::class,
            ],
            /** Test North East tile, North Face */
            [
                $this->circleCompleteCityDisconnectedCornerMap(),
                new Coordinate(1, 1),
                'North',
                1,
                false,
                Road::class,
            ],
            /** Test North East tile, East Face */
            [
                $this->circleCompleteCityDisconnectedCornerMap(),
                new Coordinate(1, 1),
                'East',
                1,
                false,
                Road::class,
            ],
            /** Test North East tile, South Face */
            [
                $this->circleCompleteCityDisconnectedCornerMap(),
                new Coordinate(1, 1),
                'South',
                8,
                true,
                City::class,
            ],
            /** Test North East tile, West Face */
            [
                $this->circleCompleteCityDisconnectedCornerMap(),
                new Coordinate(1, 1),
                'West',
                8,
                true,
                City::class,
            ],
            /** Test West tile, North Face */
            [
                $this->circleCompleteCityDisconnectedCornerMap(),
                new Coordinate(-1, 0),
                'North',
                8,
                true,
                City::class,
            ],
            /** Test West tile, East Face */
            [
                $this->circleCompleteCityDisconnectedCornerMap(),
                new Coordinate(-1, 0),
                'East',
                1,
                false,
                Road::class,
            ],
            /** Test West tile, South Face */
            [
                $this->circleCompleteCityDisconnectedCornerMap(),
                new Coordinate(-1, 0),
                'South',
                8,
                true,
                City::class,
            ],
            /** Test West tile, West Face */
            [
                $this->circleCompleteCityDisconnectedCornerMap(),
                new Coordinate(-1, 0),
                'West',
                1,
                false,
                Road::class,
            ],
            /** Test East tile, North Face */
            [
                $this->circleCompleteCityDisconnectedCornerMap(),
                new Coordinate(1, 0),
                'North',
                8,
                true,
                City::class,
            ],
            /** Test East tile, East Face */
            [
                $this->circleCompleteCityDisconnectedCornerMap(),
                new Coordinate(1, 0),
                'East',
                1,
                false,
                Road::class,
            ],
            /** Test East tile, South Face */
            [
                $this->circleCompleteCityDisconnectedCornerMap(),
                new Coordinate(1, 0),
                'South',
                8,
                true,
                City::class,
            ],
            /** Test East tile, West Face */
            [
                $this->circleCompleteCityDisconnectedCornerMap(),
                new Coordinate(1, 0),
                'West',
                1,
                false,
                Road::class,
            ],
            /** Test South West tile, North Face */
            [
                $this->circleCompleteCityDisconnectedCornerMap(),
                new Coordinate(-1, -1),
                'North',
                8,
                true,
                City::class,
            ],
            /** Test South West tile, East Face */
            [
                $this->circleCompleteCityDisconnectedCornerMap(),
                new Coordinate(-1, -1),
                'East',
                8,
                true,
                City::class,
            ],
            /** Test South West tile, South Face */
            [
                $this->circleCompleteCityDisconnectedCornerMap(),
                new Coordinate(-1, -1),
                'South',
                1,
                false,
                Road::class,
            ],
            /** Test South West tile, West Face */
            [
                $this->circleCompleteCityDisconnectedCornerMap(),
                new Coordinate(-1, -1),
                'West',
                1,
                false,
                Road::class,
            ],
            /** Test South tile, North Face */
            [
                $this->circleCompleteCityDisconnectedCornerMap(),
                new Coordinate(0, -1),
                'North',
                1,
                false,
                Road::class,
            ],
            /** Test South tile, East Face */
            [
                $this->circleCompleteCityDisconnectedCornerMap(),
                new Coordinate(0, -1),
                'East',
                8,
                true,
                City::class,
            ],
            /** Test South tile, South Face */
            [
                $this->circleCompleteCityDisconnectedCornerMap(),
                new Coordinate(0, -1),
                'South',
                1,
                false,
                Road::class,
            ],
            /** Test South tile, West Face */
            [
                $this->circleCompleteCityDisconnectedCornerMap(),
                new Coordinate(0, -1),
                'West',
                8,
                true,
                City::class,
            ],
            /** Test South East tile, North Face */
            [
                $this->circleCompleteCityDisconnectedCornerMap(),
                new Coordinate(1, -1),
                'North',
                8,
                true,
                City::class,
            ],
            /** Test South East tile, East Face */
            [
                $this->circleCompleteCityDisconnectedCornerMap(),
                new Coordinate(1, -1),
                'East',
                1,
                false,
                Road::class,
            ],
            /** Test South East tile, South Face */
            [
                $this->circleCompleteCityDisconnectedCornerMap(),
                new Coordinate(1, -1),
                'South',
                1,
                false,
                Road::class,
            ],
            /** Test South East tile, West Face */
            [
                $this->circleCompleteCityDisconnectedCornerMap(),
                new Coordinate(1, -1),
                'West',
                8,
                true,
                City::class,
            ],
        ];
    }
}
