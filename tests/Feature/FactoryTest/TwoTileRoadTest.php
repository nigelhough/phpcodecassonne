<?php
declare(strict_types = 1);

namespace Codecassonne\Feature\FactoryTest;

use Codecassonne\Feature\Road;
use Codecassonne\Map\Map;
use Codecassonne\Map\Coordinate;
use Codecassonne\Tile\Tile;

/**
 * A Two Tile Road
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
class TwoTileRoadCreation extends FeatureCreation
{
    /**
     * Create a Two Tile Road Map
     *
     * @return Map
     */
    private function twoTileRoadMap()
    {
        return $this->createMap(
            [
                (new Coordinate(0, 0))->toHash() =>
                    Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CLOISTER),
                (new Coordinate(0, 1))->toHash() =>
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
                $this->twoTileRoadMap(),
                new Coordinate(0, 1),
                'South',
                2,
                true,
                Road::class,
            ],
            /** Test South tile, North Face */
            [
                $this->twoTileRoadMap(),
                new Coordinate(0, 0),
                'North',
                2,
                true,
                Road::class,
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
                $this->twoTileRoadMap(),
                new Coordinate(0, 1),
                3,
            ],
            /** Test South tile */
            [
                $this->twoTileRoadMap(),
                new Coordinate(0, 0),
                3,
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
                $this->twoTileRoadMap(),
                new Coordinate(0, 1),
                2,
                0,
                4,
            ],
            /** Test South tile */
            [
                $this->twoTileRoadMap(),
                new Coordinate(0, 0),
                2,
                0,
                4,
            ],
        ];
    }
}
