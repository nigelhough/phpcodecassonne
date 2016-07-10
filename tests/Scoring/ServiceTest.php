<?php

namespace Codecassonne\Scoring;

use Codecassonne\Map\Map;
use Codecassonne\Map\Coordinate;
use Codecassonne\Tile\Tile;

class ServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Data provider for scoring test
     */
    public function scoringProvider()
    {
        return [
            /** Create Two Tile City Map  */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, 1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                    ]
                ),
                new Coordinate(0, 1),
                4,
            ],
            /** Create Three Tile City Map  */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, 1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, 2))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                    ]
                ),
                new Coordinate(0, 1),
                6,
            ],
            /** Create Four Tile Circle City Map  */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, 1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                    ]
                ),
                new Coordinate(0, 1),
                6,
            ],
            /** Create Five Tiles, 4 Cities Map, Score 4 City */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                    ]
                ),
                new Coordinate(0, 0),
                16,
            ],
            /** Create Five Tiles, 4 Cities Map, Score 1 (North) City */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                    ]
                ),
                new Coordinate(0, 1),
                4,
            ],
            /** Create Five Tiles, 4 Cities Map, Score 1 (East) City */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                    ]
                ),
                new Coordinate(1, 0),
                4,
            ],
            /** Create Five Tiles, 4 Cities Map, Score 1 (South) City */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                    ]
                ),
                new Coordinate(0, -1),
                4,
            ],
            /** Create Five Tiles, 4 Cities Map, Score 1 (West) City */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                    ]
                ),
                new Coordinate(-1, 0),
                4,
            ],
            /** Create Five Tiles, 1 City, Place center */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                    ]
                ),
                new Coordinate(0, 0),
                10,
            ],
            /** Create Five Tiles, 1 City, Place North */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                    ]
                ),
                new Coordinate(0, 1),
                10,
            ],
            /** Create Five Tiles, 1 City, Place East */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                    ]
                ),
                new Coordinate(1, 0),
                10,
            ],
            /** Create Five Tiles, 1 City, Place South */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                    ]
                ),
                new Coordinate(0, -1),
                10,
            ],
            /** Create Five Tiles, 1 City, Place West */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                    ]
                ),
                new Coordinate(-1, 0),
                10,
            ],
            /** Create Nine Tile City, Score North West */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, -1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS. ":" . Tile::TILE_TYPE_CITY),
                    ]
                ),
                new Coordinate(-1, 1),
                18,
            ],
            /** Create Nine Tile City, Score North */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, -1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS. ":" . Tile::TILE_TYPE_CITY),
                    ]
                ),
                new Coordinate(0, 1),
                18,
            ],
            /** Create Nine Tile City, Score North East */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, -1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS. ":" . Tile::TILE_TYPE_CITY),
                    ]
                ),
                new Coordinate(1, 1),
                18,
            ],
            /** Create Nine Tile City, Score West */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, -1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS. ":" . Tile::TILE_TYPE_CITY),
                    ]
                ),
                new Coordinate(-1, 0),
                18,
            ],
            /** Create Nine Tile City, Score Center */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, -1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS. ":" . Tile::TILE_TYPE_CITY),
                    ]
                ),
                new Coordinate(0, 0),
                18,
            ],
            /** Create Nine Tile City, Score East */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, -1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS. ":" . Tile::TILE_TYPE_CITY),
                    ]
                ),
                new Coordinate(1, 0),
                18,
            ],
            /** Create Nine Tile City, Score South West */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, -1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS. ":" . Tile::TILE_TYPE_CITY),
                    ]
                ),
                new Coordinate(-1, -1),
                18,
            ],
            /** Create Nine Tile City, Score South */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, -1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS. ":" . Tile::TILE_TYPE_CITY),
                    ]
                ),
                new Coordinate(0, -1),
                18,
            ],
            /** Create Nine Tile City, Score South East */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, -1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS. ":" . Tile::TILE_TYPE_CITY),
                    ]
                ),
                new Coordinate(1, -1),
                18,
            ],
            /** Create Nine Tile Circular City, Score North West */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, -1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS. ":" . Tile::TILE_TYPE_CITY),
                    ]
                ),
                new Coordinate(-1, 1),
                16,
            ],
            /** Create Nine Tile Circular City, Score North */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, -1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS. ":" . Tile::TILE_TYPE_CITY),
                    ]
                ),
                new Coordinate(0, 1),
                16,
            ],
            /** Create Nine Tile Circular City, Score North East */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, -1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS. ":" . Tile::TILE_TYPE_CITY),
                    ]
                ),
                new Coordinate(1, 1),
                16,
            ],
            /** Create Nine Tile Circular City, Score West */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, -1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS. ":" . Tile::TILE_TYPE_CITY),
                    ]
                ),
                new Coordinate(-1, 0),
                16,
            ],
            /** Create Nine Tile Circular City, Center */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, -1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS. ":" . Tile::TILE_TYPE_CITY),
                    ]
                ),
                new Coordinate(0, 0),
                0,
            ],
            /** Create Nine Tile Circular City, Score East */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, -1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS. ":" . Tile::TILE_TYPE_CITY),
                    ]
                ),
                new Coordinate(0, 1),
                16,
            ],
            /** Create Nine Tile Circular City, Score South West */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, -1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS. ":" . Tile::TILE_TYPE_CITY),
                    ]
                ),
                new Coordinate(-1, -1),
                16,
            ],
            /** Create Nine Tile Circular City, Score South */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, -1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS. ":" . Tile::TILE_TYPE_CITY),
                    ]
                ),
                new Coordinate(0, -1),
                16,
            ],
            /** Create Nine Tile Circular City, Score South East */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, -1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS. ":" . Tile::TILE_TYPE_CITY),
                    ]
                ),
                new Coordinate(1, -1),
                16,
            ],
            /** Create Nine Tile, 4 Corner Cities, Place North West  */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(1, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(1, -1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(-1, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(-1, 1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS. ":" . Tile::TILE_TYPE_CITY),
                    ]
                ),
                new Coordinate(-1, 1),
                6,
            ],
            /** Create Nine Tile, 4 Corner Cities, Place North  */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(1, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(1, -1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(-1, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(-1, 1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS. ":" . Tile::TILE_TYPE_CITY),
                    ]
                ),
                new Coordinate(0, 1),
                12,
            ],
            /** Create Nine Tile, 4 Corner Cities, Place North East  */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(1, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(1, -1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(-1, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(-1, 1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS. ":" . Tile::TILE_TYPE_CITY),
                    ]
                ),
                new Coordinate(1, 1),
                6,
            ],
            /** Create Nine Tile, 4 Corner Cities, Place West  */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(1, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(1, -1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(-1, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(-1, 1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS. ":" . Tile::TILE_TYPE_CITY),
                    ]
                ),
                new Coordinate(-1, 0),
                12,
            ],
            /** Create Nine Tile, 4 Corner Cities, Place Center  */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(1, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(1, -1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(-1, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(-1, 1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS. ":" . Tile::TILE_TYPE_CITY),
                    ]
                ),
                new Coordinate(0, 0),
                0,
            ],
            /** Create Nine Tile, 4 Corner Cities, Place East  */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(1, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(1, -1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(-1, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(-1, 1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS. ":" . Tile::TILE_TYPE_CITY),
                    ]
                ),
                new Coordinate(1, 0),
                12,
            ],
            /** Create Nine Tile, 4 Corner Cities, Place South West  */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(1, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(1, -1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(-1, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(-1, 1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS. ":" . Tile::TILE_TYPE_CITY),
                    ]
                ),
                new Coordinate(-1, -1),
                6,
            ],
            /** Create Nine Tile, 4 Corner Cities, Place South  */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(1, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(1, -1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(-1, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(-1, 1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS. ":" . Tile::TILE_TYPE_CITY),
                    ]
                ),
                new Coordinate(0, -1),
                12,
            ],
            /** Create Nine Tile, 4 Corner Cities, Place South East */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(1, 1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 0))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(1, -1))->toHash()  =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(0, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(-1, -1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(-1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(-1, 1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS. ":" . Tile::TILE_TYPE_CITY),
                    ]
                ),
                new Coordinate(1, -1),
                6,
            ],
            /** Create Four Tile Circle City Map  */
            [
                $this->createMap(
                    [
                        (new Coordinate(0, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0, 1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY),
                        (new Coordinate(1, 1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(1, 0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                    ]
                ),
                new Coordinate(0, 1),
                6,
            ],


//            /** Create Two Tile Road Map  */
//            [
//                $this->createMap(
//                    [
//                        (new Coordinate(0, 0))->toHash() =>
//                            Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD),
//                        (new Coordinate(0, 1))->toHash() =>
//                            Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD),
//                    ]
//                ),
//                new Coordinate(0, 1),
//                2,
//            ],
        ];
    }

    /**
     * Creates a map from an array of tiles
     *
     * @param array $tiles Array of tiles to set the state of the map
     *
     * @return Map
     */
    private function createMap(array $tiles)
    {
        //Dummy Tile
        $tile = Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS);

        // Create Map
        $map = new Map($tile);

        // Make Map properties accessible
        $mapReflection = new \ReflectionClass('Codecassonne\Map\Map');
        $tilesReflection = $mapReflection->getProperty('tiles');
        $tilesReflection->setAccessible(true);

        // Set the Bag Tiles
        $tilesReflection->setValue($map, $tiles);

        return $map;
    }

    /**
     * Test the scoring service, when passed a map and a coordinate to score the expected score is returned
     *
     * @param Map        $map              Map to score
     * @param Coordinate $placedCoordinate Coordinate to score
     * @param int        $expectedScore    Expected Score
     *
     * @dataProvider scoringProvider
     */
    public function testScoring(Map $map, Coordinate $placedCoordinate, int $expectedScore)
    {
        $map->updateMinimumBoundingRectangle(new Coordinate(-2, -2));
        $map->updateMinimumBoundingRectangle(new Coordinate(2, 2));
        $map->render();

        $scoringService = new Service();
        //Test calculating the score
        $score = $scoringService->calculateScore($map, $placedCoordinate);

        //Check the score is as expected
        $this->assertEquals($expectedScore, $score);
    }
}
