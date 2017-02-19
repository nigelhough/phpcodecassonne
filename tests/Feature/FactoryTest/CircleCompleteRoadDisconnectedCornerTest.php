<?php
declare(strict_types = 1);

namespace Codecassonne\Feature\FactoryTest;

use Codecassonne\Feature\Road;
use Codecassonne\Feature\City;
use Codecassonne\Map\Map;
use Codecassonne\Map\Coordinate;
use Codecassonne\Tile\Tile;

/**
 * A Circle Complete Road disconnected in corner
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
 *                                |    R    |  |    C    |  |    C    |
 *                                |         |  |         |  |         |
 * 1                              |R   R   R|  |R   R   R|  |R   R   C|
 *                                |         |  |         |  |         |
 *                                |    R    |  |    C    |  |    R    |
 *                                -----------  -----------  -----------
 *                                -----------               -----------
 *                                |    R    |               |    R    |
 *                                |         |               |         |
 * 0                              |C   R   C|               |C   R   C|
 *                                |         |               |         |
 *                                |    R    |               |    R    |
 *                                -----------  -----------  -----------
 *                                -----------  -----------  -----------
 *                                |    R    |  |    C    |  |    R    |
 *                                |         |  |         |  |         |
 * -1                             |C   R   R|  |R   R   R|  |R   R   C|
 *                                |         |  |         |  |         |
 *                                |    C    |  |    C    |  |    C    |
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
class CircleCompleteRoadDisconnectedCornerTest extends CreateFeatureTest
{
    /**
     * Create a square complete road
     *
     * @return Map
     */
    private function circleCompleteRoadDisconnectedCornerMap()
    {
        return $this->createMap(
            [
                (new Coordinate(0, 1))->toHash()   =>
                    Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD),
                (new Coordinate(1, 1))->toHash()   =>
                    Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD),
                (new Coordinate(1, 0))->toHash()   =>
                    Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD),
                (new Coordinate(1, -1))->toHash()  =>
                    Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD),
                (new Coordinate(0, -1))->toHash()  =>
                    Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD),
                (new Coordinate(-1, -1))->toHash() =>
                    Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD),
                (new Coordinate(-1, 0))->toHash()  =>
                    Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD),
                (new Coordinate(-1, 1))->toHash()  =>
                    Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD),
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
                $this->circleCompleteRoadDisconnectedCornerMap(),
                new Coordinate(-1, 1),
                'North',
                1,
                false,
                Road::class,
            ],
            /** Test North West tile, East Face */
            [
                $this->circleCompleteRoadDisconnectedCornerMap(),
                new Coordinate(-1, 1),
                'East',
                8,
                true,
                Road::class,
                ['South'],
            ],
            /** Test North West tile, South Face */
            [
                $this->circleCompleteRoadDisconnectedCornerMap(),
                new Coordinate(-1, 1),
                'South',
                8,
                true,
                Road::class,
                ['East'],
            ],
            /** Test North West tile, West Face */
            [
                $this->circleCompleteRoadDisconnectedCornerMap(),
                new Coordinate(-1, 1),
                'West',
                1,
                false,
                Road::class,
            ],
            /** Test North tile, North Face */
            [
                $this->circleCompleteRoadDisconnectedCornerMap(),
                new Coordinate(0, 1),
                'North',
                1,
                false,
                City::class,
            ],
            /** Test North tile, East Face */
            [
                $this->circleCompleteRoadDisconnectedCornerMap(),
                new Coordinate(0, 1),
                'East',
                8,
                true,
                Road::class,
            ],
            /** Test North tile, South Face */
            [
                $this->circleCompleteRoadDisconnectedCornerMap(),
                new Coordinate(0, 1),
                'South',
                1,
                false,
                City::class,
            ],
            /** Test North tile, West Face */
            [
                $this->circleCompleteRoadDisconnectedCornerMap(),
                new Coordinate(0, 1),
                'West',
                8,
                true,
                Road::class,
            ],
            /** Test North East tile, North Face */
            [
                $this->circleCompleteRoadDisconnectedCornerMap(),
                new Coordinate(1, 1),
                'North',
                1,
                false,
                City::class,
            ],
            /** Test North East tile, East Face */
            [
                $this->circleCompleteRoadDisconnectedCornerMap(),
                new Coordinate(1, 1),
                'East',
                1,
                false,
                City::class,
            ],
            /** Test North East tile, South Face */
            [
                $this->circleCompleteRoadDisconnectedCornerMap(),
                new Coordinate(1, 1),
                'South',
                8,
                true,
                Road::class,
            ],
            /** Test North East tile, West Face */
            [
                $this->circleCompleteRoadDisconnectedCornerMap(),
                new Coordinate(1, 1),
                'West',
                8,
                true,
                Road::class,
            ],
            /** Test West tile, North Face */
            [
                $this->circleCompleteRoadDisconnectedCornerMap(),
                new Coordinate(-1, 0),
                'North',
                8,
                true,
                Road::class,
            ],
            /** Test West tile, East Face */
            [
                $this->circleCompleteRoadDisconnectedCornerMap(),
                new Coordinate(-1, 0),
                'East',
                1,
                false,
                City::class,
            ],
            /** Test West tile, South Face */
            [
                $this->circleCompleteRoadDisconnectedCornerMap(),
                new Coordinate(-1, 0),
                'South',
                8,
                true,
                Road::class,
            ],
            /** Test West tile, West Face */
            [
                $this->circleCompleteRoadDisconnectedCornerMap(),
                new Coordinate(-1, 0),
                'West',
                1,
                false,
                City::class,
            ],
            /** Test East tile, North Face */
            [
                $this->circleCompleteRoadDisconnectedCornerMap(),
                new Coordinate(1, 0),
                'North',
                8,
                true,
                Road::class,
            ],
            /** Test East tile, East Face */
            [
                $this->circleCompleteRoadDisconnectedCornerMap(),
                new Coordinate(1, 0),
                'East',
                1,
                false,
                City::class,
            ],
            /** Test East tile, South Face */
            [
                $this->circleCompleteRoadDisconnectedCornerMap(),
                new Coordinate(1, 0),
                'South',
                8,
                true,
                Road::class,
            ],
            /** Test East tile, West Face */
            [
                $this->circleCompleteRoadDisconnectedCornerMap(),
                new Coordinate(1, 0),
                'West',
                1,
                false,
                City::class,
            ],
            /** Test South West tile, North Face */
            [
                $this->circleCompleteRoadDisconnectedCornerMap(),
                new Coordinate(-1, -1),
                'North',
                8,
                true,
                Road::class,
            ],
            /** Test South West tile, East Face */
            [
                $this->circleCompleteRoadDisconnectedCornerMap(),
                new Coordinate(-1, -1),
                'East',
                8,
                true,
                Road::class,
            ],
            /** Test South West tile, South Face */
            [
                $this->circleCompleteRoadDisconnectedCornerMap(),
                new Coordinate(-1, -1),
                'South',
                1,
                false,
                City::class,
            ],
            /** Test South West tile, West Face */
            [
                $this->circleCompleteRoadDisconnectedCornerMap(),
                new Coordinate(-1, -1),
                'West',
                1,
                false,
                City::class,
            ],
            /** Test South tile, North Face */
            [
                $this->circleCompleteRoadDisconnectedCornerMap(),
                new Coordinate(0, -1),
                'North',
                1,
                false,
                City::class,
            ],
            /** Test South tile, East Face */
            [
                $this->circleCompleteRoadDisconnectedCornerMap(),
                new Coordinate(0, -1),
                'East',
                8,
                true,
                Road::class,
            ],
            /** Test South tile, South Face */
            [
                $this->circleCompleteRoadDisconnectedCornerMap(),
                new Coordinate(0, -1),
                'South',
                1,
                false,
                City::class,
            ],
            /** Test South tile, West Face */
            [
                $this->circleCompleteRoadDisconnectedCornerMap(),
                new Coordinate(0, -1),
                'West',
                8,
                true,
                Road::class,
            ],
            /** Test South East tile, North Face */
            [
                $this->circleCompleteRoadDisconnectedCornerMap(),
                new Coordinate(1, -1),
                'North',
                8,
                true,
                Road::class,
            ],
            /** Test South East tile, East Face */
            [
                $this->circleCompleteRoadDisconnectedCornerMap(),
                new Coordinate(1, -1),
                'East',
                1,
                false,
                City::class,
            ],
            /** Test South East tile, South Face */
            [
                $this->circleCompleteRoadDisconnectedCornerMap(),
                new Coordinate(1, -1),
                'South',
                1,
                false,
                City::class,
            ],
            /** Test South East tile, West Face */
            [
                $this->circleCompleteRoadDisconnectedCornerMap(),
                new Coordinate(1, -1),
                'West',
                8,
                true,
                Road::class,
            ],
        ];
    }
}
