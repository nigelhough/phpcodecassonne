<?php
declare(strict_types = 1);

namespace Codecassonne\Feature\FactoryTest;

use Codecassonne\Feature\Road;
use Codecassonne\Map\Map;
use Codecassonne\Map\Coordinate;
use Codecassonne\Tile\Tile;

/**
 * A Three Tile Road
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
 * 2                                           |G   M   G|
 *                                             |         |
 *                                             |    R    |
 *                                             -----------
 *                                             -----------
 *                                             |    R    |
 *                                             |         |
 * 1                                           |G   R   G|
 *                                             |         |
 *                                             |    R    |
 *                                             -----------
 *                                             -----------
 *                                             |    R    |
 *                                             |         |
 * 0                                           |G   M   G|
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
class ThreeTileRoadCreation extends FeatureCreation
{
    /**
     * Create a Three Tile Road Map
     *
     * @return Map
     */
    private function threeTileRoadMap()
    {
        return $this->createMap(
            [
                (new Coordinate(0, 0))->toHash() =>
                    Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CLOISTER),
                (new Coordinate(0, 1))->toHash() =>
                    Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD),
                (new Coordinate(0, 2))->toHash() =>
                    Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CLOISTER),
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
                $this->threeTileRoadMap(),
                new Coordinate(0, 2),
                'South',
                3,
                true,
                Road::class
            ],
            /** Test Center tile, North Face */
            [
                $this->threeTileRoadMap(),
                new Coordinate(0, 1),
                'North',
                3,
                true,
                Road::class
            ],
            /** Test Center tile, South Face */
            [
                $this->threeTileRoadMap(),
                new Coordinate(0, 1),
                'South',
                3,
                true,
                Road::class
            ],
            /** Test South tile, North Face */
            [
                $this->threeTileRoadMap(),
                new Coordinate(0, 0),
                'North',
                3,
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
                $this->threeTileRoadMap(),
                new Coordinate(0, 2),
                1,
            ],
            /** Test Center tile */
            [
                $this->threeTileRoadMap(),
                new Coordinate(0, 1),
                1,
            ],
            /** Test South tile */
            [
                $this->threeTileRoadMap(),
                new Coordinate(0, 0),
                1,
            ],
        ];
    }
}
