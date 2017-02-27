<?php
declare(strict_types = 1);

namespace Codecassonne\Feature\FactoryTest;

use Codecassonne\Feature\Road;
use Codecassonne\Map\Map;
use Codecassonne\Map\Coordinate;
use Codecassonne\Tile\Tile;

/**
 * A Cross Shaped Road, Separate Disconnected Roads
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
 * 0                              |G   M   R|  |R   M   R|  |R   M   G|
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
class CrossCompleteSeperateRoadCreation extends FeatureCreation
{
    /**
     * Create a Cross Road Map with features disconnected
     *
     * @return Map
     */
    private function crossCompleteRoadMap()
    {
        return $this->createMap(
            [
                (new Coordinate(0, 0))->toHash()  =>
                    Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CLOISTER),
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
                $this->crossCompleteRoadMap(),
                new Coordinate(0, 1),
                5,
            ],
            /** Test West tile */
            [
                $this->crossCompleteRoadMap(),
                new Coordinate(-1, 0),
                5,
            ],
            /** Test Center tile */
            [
                $this->crossCompleteRoadMap(),
                new Coordinate(0, 0),
                9,
            ],
            /** Test East tile */
            [
                $this->crossCompleteRoadMap(),
                new Coordinate(1, 0),
                5,
            ],
            /** Test South tile */
            [
                $this->crossCompleteRoadMap(),
                new Coordinate(0, -1),
                5,
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
                $this->crossCompleteRoadMap(),
                new Coordinate(0, 1),
                4,
                0,
                17,
            ],
            /** Test West tile */
            [
                $this->crossCompleteRoadMap(),
                new Coordinate(-1, 0),
                4,
                0,
                17,
            ],
            /** Test Center tile */
            [
                $this->crossCompleteRoadMap(),
                new Coordinate(0, 0),
                5,
                0,
                21,
            ],
            /** Test East tile */
            [
                $this->crossCompleteRoadMap(),
                new Coordinate(1, 0),
                4,
                0,
                17,
            ],
            /** Test South tile */
            [
                $this->crossCompleteRoadMap(),
                new Coordinate(0, -1),
                4,
                0,
                17,
            ],
        ];
    }
}
