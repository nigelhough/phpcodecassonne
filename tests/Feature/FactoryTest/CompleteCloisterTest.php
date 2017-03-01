<?php
declare(strict_types = 1);

namespace Codecassonne\Feature\FactoryTest;

use Codecassonne\Feature\Road;
use Codecassonne\Feature\City;
use Codecassonne\Map\Map;
use Codecassonne\Map\Coordinate;
use Codecassonne\Tile\Tile;

/**
 * A Square Complete Cloister
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
 *                                |    C    |  |    C    |  |    C    |
 *                                |         |  |         |  |         |
 * 1                              |C   C   G|  |G   G   G|  |G   C   C|
 *                                |         |  |         |  |         |
 *                                |    G    |  |    G    |  |    G    |
 *                                -----------  -----------  -----------
 *                                -----------  -----------  -----------
 *                                |    G    |  |    G    |  |    G    |
 *                                |         |  |         |  |         |
 * 0                              |C   G   G|  |G   M   G|  |G   G   C|
 *                                |         |  |         |  |         |
 *                                |    G    |  |    G    |  |    G    |
 *                                -----------  -----------  -----------
 *                                -----------  -----------  -----------
 *                                |    G    |  |    G    |  |    G    |
 *                                |         |  |         |  |         |
 * -1                             |C   C   G|  |G   G   G|  |G   C   C|
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
class CompleteCloisterTest extends FeatureCreation
{
    /**
     * Create a square complete city
     *
     * @return Map
     */
    private function completeCloisterMap()
    {
        return $this->createMap(
            [
                (new Coordinate(0, 0))->toHash()   =>
                    Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CLOISTER),
                (new Coordinate(0, 1))->toHash()   =>
                    Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                (new Coordinate(1, 1))->toHash()   =>
                    Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                (new Coordinate(1, 0))->toHash()   =>
                    Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                (new Coordinate(1, -1))->toHash()  =>
                    Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                (new Coordinate(0, -1))->toHash()  =>
                    Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                (new Coordinate(-1, -1))->toHash() =>
                    Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                (new Coordinate(-1, 0))->toHash()  =>
                    Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                (new Coordinate(-1, 1))->toHash()  =>
                    Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
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
                $this->completeCloisterMap(),
                new Coordinate(-1, 1),
                'North',
                1,
                false,
                City::class,
            ],
            /** Test North West tile, West Face */
            [
                $this->completeCloisterMap(),
                new Coordinate(-1, 1),
                'West',
                1,
                false,
                City::class,
            ],
            /** Test North tile, North Face */
            [
                $this->completeCloisterMap(),
                new Coordinate(0, 1),
                'North',
                1,
                false,
                City::class,
            ],
            /** Test North East tile, North Face */
            [
                $this->completeCloisterMap(),
                new Coordinate(1, 1),
                'North',
                1,
                false,
                City::class,
            ],
            /** Test North East tile, East Face */
            [
                $this->completeCloisterMap(),
                new Coordinate(1, 1),
                'East',
                1,
                false,
                City::class,
            ],
            /** Test West tile, West Face */
            [
                $this->completeCloisterMap(),
                new Coordinate(-1, 0),
                'West',
                1,
                false,
                City::class,
            ],
            /** Test East tile, East Face */
            [
                $this->completeCloisterMap(),
                new Coordinate(1, 0),
                'East',
                1,
                false,
                City::class,
            ],
            /** Test South West tile, South Face */
            [
                $this->completeCloisterMap(),
                new Coordinate(-1, -1),
                'South',
                1,
                false,
                City::class,
            ],
            /** Test South West tile, West Face */
            [
                $this->completeCloisterMap(),
                new Coordinate(-1, -1),
                'West',
                1,
                false,
                City::class,
            ],
            /** Test South tile, South Face */
            [
                $this->completeCloisterMap(),
                new Coordinate(0, -1),
                'South',
                1,
                false,
                City::class,
            ],
            /** Test South East tile, East Face */
            [
                $this->completeCloisterMap(),
                new Coordinate(1, -1),
                'East',
                1,
                false,
                City::class,
            ],
            /** Test South East tile, South Face */
            [
                $this->completeCloisterMap(),
                new Coordinate(1, -1),
                'South',
                1,
                false,
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
                $this->completeCloisterMap(),
                new Coordinate(-1, 1),
                2,
            ],
            /** Test North tile */
            [
                $this->completeCloisterMap(),
                new Coordinate(0, 1),
                2,
            ],
            /** Test North East tile */
            [
                $this->completeCloisterMap(),
                new Coordinate(1, 1),
                2,
            ],
            /** Test West tile */
            [
                $this->completeCloisterMap(),
                new Coordinate(-1, 0),
                2,
            ],
            /** Test Center tile */
            [
                $this->completeCloisterMap(),
                new Coordinate(0, 0),
                1,
            ],
            /** Test East tile */
            [
                $this->completeCloisterMap(),
                new Coordinate(1, 0),
                2,
            ],
            /** Test South West tile */
            [
                $this->completeCloisterMap(),
                new Coordinate(-1, -1),
                2,
            ],
            /** Test South West tile */
            [
                $this->completeCloisterMap(),
                new Coordinate(0, -1),
                2,
            ],
            /** Test South East tile */
            [
                $this->completeCloisterMap(),
                new Coordinate(1, -1),
                2,
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
                $this->completeCloisterMap(),
                new Coordinate(-1, 1),
                1,
                1,
                9,
            ],
            /** Test North tile */
            [
                $this->completeCloisterMap(),
                new Coordinate(0, 1),
                1,
                1,
                9,
            ],
            /** Test North East tile */
            [
                $this->completeCloisterMap(),
                new Coordinate(1, 1),
                1,
                1,
                9,
            ],
            /** Test West tile */
            [
                $this->completeCloisterMap(),
                new Coordinate(-1, 0),
                1,
                1,
                9,
            ],
            /** Test Center tile */
            [
                $this->completeCloisterMap(),
                new Coordinate(0, 0),
                1,
                1,
                9,
            ],
            /** Test East tile */
            [
                $this->completeCloisterMap(),
                new Coordinate(1, 0),
                1,
                1,
                9,
            ],
            /** Test South West tile */
            [
                $this->completeCloisterMap(),
                new Coordinate(-1, -1),
                1,
                1,
                9,
            ],
            /** Test South West tile */
            [
                $this->completeCloisterMap(),
                new Coordinate(0, -1),
                1,
                1,
                9,
            ],
            /** Test South East tile */
            [
                $this->completeCloisterMap(),
                new Coordinate(1, -1),
                1,
                1,
                9,
            ],
        ];
    }
}
