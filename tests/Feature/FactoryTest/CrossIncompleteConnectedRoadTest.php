<?php

namespace Codecassonne\Feature\FactoryTest;

use Codecassonne\Feature\Road;
use Codecassonne\Map\Map;
use Codecassonne\Map\Coordinate;
use Codecassonne\Tile\Tile;

/**
 * A Cross Shaped Road, Separate Connected Roads, Incomplete
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
 *                                             |    R    |
 *                                             |         |
 * 1                                           |G   R   G|
 *                                             |         |
 *                                             |    R    |
 *                                             -----------
 *                                -----------  -----------  -----------
 *                                |    G    |  |    R    |  |    G    |
 *                                |         |  |         |  |         |
 * 0                              |R   R   R|  |R   R   R|  |R   R   R|
 *                                |         |  |         |  |         |
 *                                |    G    |  |    R    |  |    G    |
 *                                -----------  -----------  -----------
 *                                             -----------
 *                                             |    C    |
 *                                             |         |
 * -1                                          |G   R   G|
 *                                             |         |
 *                                             |    R    |
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
class CrossIncompleteConnectedRoadCreation extends FeatureCreation
{
    /**
     * Create a Cross Road Map with features connected and incomplete
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
                    Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD),
                (new Coordinate(1, 0))->toHash()  =>
                    Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD),
                (new Coordinate(0, -1))->toHash() =>
                    Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD),
                (new Coordinate(-1, 0))->toHash() =>
                    Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD),
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
                false,
                Road::class
            ],
            /** Test East tile, West Face */
            [
                $this->crossCompleteRoadMap(),
                new Coordinate(1, 0),
                'West',
                2,
                false,
                Road::class
            ],
            /** Test South tile, North Face */
            [
                $this->crossCompleteRoadMap(),
                new Coordinate(0, -1),
                'North',
                2,
                false,
                Road::class
            ],
            /** Test West tile, East Face */
            [
                $this->crossCompleteRoadMap(),
                new Coordinate(-1, 0),
                'East',
                2,
                false,
                Road::class
            ],
            /** Test Center tile, North Face */
            [
                $this->crossCompleteRoadMap(),
                new Coordinate(0, 0),
                'North',
                2,
                false,
                Road::class
            ],
            /** Test Center tile, East Face */
            [
                $this->crossCompleteRoadMap(),
                new Coordinate(0, 0),
                'East',
                2,
                false,
                Road::class
            ],
            /** Test Center tile, South Face */
            [
                $this->crossCompleteRoadMap(),
                new Coordinate(0, 0),
                'South',
                2,
                false,
                Road::class
            ],
            /** Test Center tile, West Face */
            [
                $this->crossCompleteRoadMap(),
                new Coordinate(0, 0),
                'West',
                2,
                false,
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
                1,
            ],
            /** Test West tile */
            [
                $this->crossCompleteRoadMap(),
                new Coordinate(-1, 0),
                1,
            ],
            /** Test Center tile */
            [
                $this->crossCompleteRoadMap(),
                new Coordinate(0, 0),
                4,
            ],
            /** Test East tile */
            [
                $this->crossCompleteRoadMap(),
                new Coordinate(1, 0),
                1,
            ],
            /** Test South tile */
            [
                $this->crossCompleteRoadMap(),
                new Coordinate(0, -1),
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
                $this->crossCompleteRoadMap(),
                new Coordinate(0, 1),
                0,
                0,
                0,
            ],
            /** Test West tile */
            [
                $this->crossCompleteRoadMap(),
                new Coordinate(-1, 0),
                0,
                0,
                0,
            ],
            /** Test Center tile */
            [
                $this->crossCompleteRoadMap(),
                new Coordinate(0, 0),
                0,
                0,
                0,
            ],
            /** Test East tile */
            [
                $this->crossCompleteRoadMap(),
                new Coordinate(1, 0),
                0,
                0,
                0,
            ],
            /** Test South tile */
            [
                $this->crossCompleteRoadMap(),
                new Coordinate(0, -1),
                0,
                0,
                0,
            ],
        ];
    }
}
