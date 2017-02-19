<?php

namespace Codecassonne\Feature\FactoryTest;

use Codecassonne\Feature\Road;
use Codecassonne\Map\Map;
use Codecassonne\Map\Coordinate;
use Codecassonne\Tile\Tile;

/**
 * A Cross Shaped Road, Seperate Connected Roads
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
 * 1                                           |G   M   G|
 *                                             |         |
 *                                             |    R    |
 *                                             -----------
 *                                -----------  -----------  -----------
 *                                |    G    |  |    R    |  |    G    |
 *                                |         |  |         |  |         |
 * 0                              |G   M   R|  |R   R   R|  |R   M   G|
 *                                |         |  |         |  |         |
 *                                |    G    |  |    R    |  |    G    |
 *                                -----------  -----------  -----------
 *                                             -----------
 *                                             |    R    |
 *                                             |         |
 * -1                                          |G   M   G|
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
class CrossCompleteConnectedRoadTest extends CreateFeatureTest
{
    /**
     * Create a Cross Road Map with features connected
     *
     * @return Map
     */
    private function crossCompleteRoadMap()
    {
        return $this->createMap(
            [
                (new Coordinate(0, 0))->toHash()  =>
                    Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD),
                (new Coordinate(0, 1))->toHash()  =>
                    Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CLOISTER),
                (new Coordinate(1, 0))->toHash()  =>
                    Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CLOISTER),
                (new Coordinate(0, -1))->toHash() =>
                    Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CLOISTER),
                (new Coordinate(-1, 0))->toHash() =>
                    Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CLOISTER),
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
                $this->crossCompleteRoadMap(),
                new Coordinate(0, 1),
                'South',
                2,
                true,
                Road::class
            ],
            /** Test East tile, West Face */
            [
                $this->crossCompleteRoadMap(),
                new Coordinate(1, 0),
                'West',
                2,
                true,
                Road::class
            ],
            /** Test South tile, North Face */
            [
                $this->crossCompleteRoadMap(),
                new Coordinate(0, -1),
                'North',
                2,
                true,
                Road::class
            ],
            /** Test West tile, East Face */
            [
                $this->crossCompleteRoadMap(),
                new Coordinate(-1, 0),
                'East',
                2,
                true,
                Road::class
            ],
            /** Test Center tile, North Face */
            [
                $this->crossCompleteRoadMap(),
                new Coordinate(0, 0),
                'North',
                2,
                true,
                Road::class
            ],
            /** Test Center tile, East Face */
            [
                $this->crossCompleteRoadMap(),
                new Coordinate(0, 0),
                'East',
                2,
                true,
                Road::class
            ],
            /** Test Center tile, South Face */
            [
                $this->crossCompleteRoadMap(),
                new Coordinate(0, 0),
                'South',
                2,
                true,
                Road::class
            ],
            /** Test Center tile, West Face */
            [
                $this->crossCompleteRoadMap(),
                new Coordinate(0, 0),
                'West',
                2,
                true,
                Road::class
            ],
        ];
    }
}
