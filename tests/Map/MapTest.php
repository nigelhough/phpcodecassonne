<?php

namespace Codecassonne\Map;

use Codecassonne\Tile\Tile;

class MapTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function placeTileProvider()
    {
        return array(
            /** Place tile in a valid position then another valid position. Error */
            array(
                new Coordinate(0, 1),
                new Coordinate(0, 2),
                false,
            ),
            /** Place tile in a valid position then place another in the same place. No Error */
            array(
                new Coordinate(0, 1),
                new Coordinate(0, 1),
                true,
            ),
            /** Place a tile on the starting tile. Error (don't place second) */
            array(
                new Coordinate(0, 0),
                new Coordinate(0, 0),
                true,
            ),
            /** Place a tile in a valid position then another on the starting tile */
            array(
                new Coordinate(0, 1),
                new Coordinate(0, 0),
                true,
            ),
            /** Place two tiles in random places */
            array(
                new Coordinate(10, 06),
                new Coordinate(19, 84),
                false,
            ),
        );
    }

    /**
     * @param Coordinate $placeCoordinate1
     * @param Coordinate $placeCoordinate2
     *
     * @param $expectedException
     *
     * @throws \Exception
     *
     * @dataProvider placeTileProvider
     */
    public function testPlaceTile(Coordinate $placeCoordinate1, Coordinate $placeCoordinate2, $expectedException)
    {
        if ($expectedException) {
            $this->setExpectedException('Exception');
        }

        //Dummy Tile
        $tile = Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS);

        $map = new Map($tile);

        $map->place($tile, $placeCoordinate1);
        $map->place($tile, $placeCoordinate2);
    }

    public function renderTestProvider()
    {
        return array(
            array(
                Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD),
                " ----------- " . PHP_EOL .
                " |    G    | " . PHP_EOL .
                " |         | " . PHP_EOL .
                " |R   R   R| " . PHP_EOL .
                " |         | " . PHP_EOL .
                " |    C    | " . PHP_EOL .
                " ----------- " . PHP_EOL .
                "" . PHP_EOL .
                "",
            ),
            array(
                Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                " ----------- " . PHP_EOL .
                " |    G    | " . PHP_EOL .
                " |         | " . PHP_EOL .
                " |G   G   G| " . PHP_EOL .
                " |         | " . PHP_EOL .
                " |    G    | " . PHP_EOL .
                " ----------- " . PHP_EOL .
                "" . PHP_EOL .
                "",
            ),
            array(
                Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD),
                " ----------- " . PHP_EOL .
                " |    R    | " . PHP_EOL .
                " |         | " . PHP_EOL .
                " |R   R   R| " . PHP_EOL .
                " |         | " . PHP_EOL .
                " |    R    | " . PHP_EOL .
                " ----------- " . PHP_EOL .
                "" . PHP_EOL .
                "",
            ),
            array(
                Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY),
                " ----------- " . PHP_EOL .
                " |    C    | " . PHP_EOL .
                " |         | " . PHP_EOL .
                " |C   C   C| " . PHP_EOL .
                " |         | " . PHP_EOL .
                " |    C    | " . PHP_EOL .
                " ----------- " . PHP_EOL .
                "" . PHP_EOL .
                "",
            ),
            array(
                Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                " ----------- " . PHP_EOL .
                " |    C    | " . PHP_EOL .
                " |         | " . PHP_EOL .
                " |C   G   C| " . PHP_EOL .
                " |         | " . PHP_EOL .
                " |    C    | " . PHP_EOL .
                " ----------- " . PHP_EOL .
                "" . PHP_EOL .
                "",
            ),
        );
    }

    /**
     * Test Map Rendering function
     *
     * @param Tile $startingTile Starting Tile on Map
     * @param string $expectedOutput Expected Rendered Map
     *
     * @dataProvider renderTestProvider
     */
    public function testRender(Tile $startingTile, $expectedOutput)
    {
        //Create Test Map
        $map = new Map($startingTile);

        //Assert the Output was as expected
        $this->assertSame($expectedOutput, $this->getRenderedMap($map));
    }

    /**
     * Test Complex Map Rendering function
     */
    public function testComplexRender()
    {
        //Create Test Map
        $map = new Map(Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD));

        //Add Tile North of Starting Tile
        $map->place(
            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD),
            new Coordinate(0, 1)
        );

        //Add Tile East of second Tile
        $map->place(
            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD),
            new Coordinate(1, 1)
        );

        $expectedOutput =
            " -----------  ----------- " . PHP_EOL .
            " |    G    |  |    C    | " . PHP_EOL .
            " |         |  |         | " . PHP_EOL .
            " |R   R   R|  |R   R   R| " . PHP_EOL .
            " |         |  |         | " . PHP_EOL .
            " |    C    |  |    G    | " . PHP_EOL .
            " -----------  ----------- " . PHP_EOL .
            "              ----------- " . PHP_EOL .
            "              |    G    | " . PHP_EOL .
            "              |         | " . PHP_EOL .
            "              |R   R   R| " . PHP_EOL .
            "              |         | " . PHP_EOL .
            "              |    G    | " . PHP_EOL .
            "              ----------- " . PHP_EOL . PHP_EOL;

        //Assert the Output was as expected
        $this->assertSame($expectedOutput, $this->getRenderedMap($map));
    }


    /**
     * Render a Map and return the rendered output
     *
     * @param Map $map Map to render
     *
     * @return string
     */
    private function getRenderedMap(Map $map)
    {
        //Start Output Buffering
        ob_start();

        //Render Map
        $map->render();

        //Get Output from buffer and Clean
        $renderedMap = ob_get_contents();
        ob_end_clean();

        return $renderedMap;
    }

    /**
     * Gets the Tile Face combinations and if they match
     *
     * @return array
     */
    public function getFaceCombinations()
    {
        return array(
            array(Tile::TILE_TYPE_GRASS,    Tile::TILE_TYPE_GRASS,  true),
            array(Tile::TILE_TYPE_GRASS,    Tile::TILE_TYPE_CITY,   false),
            array(Tile::TILE_TYPE_GRASS,    Tile::TILE_TYPE_ROAD,   false),
            array(Tile::TILE_TYPE_CITY,     Tile::TILE_TYPE_GRASS,  false),
            array(Tile::TILE_TYPE_CITY,     Tile::TILE_TYPE_CITY,   true),
            array(Tile::TILE_TYPE_CITY,     Tile::TILE_TYPE_ROAD,   false),
            array(Tile::TILE_TYPE_ROAD,     Tile::TILE_TYPE_GRASS,  false),
            array(Tile::TILE_TYPE_ROAD,     Tile::TILE_TYPE_CITY,   false),
            array(Tile::TILE_TYPE_ROAD,     Tile::TILE_TYPE_ROAD,   true),
        );
    }

    /**
     * Data Provider for the two tile single face test
     *
     * @return array
     */
    public function twoTilesProvider()
    {
        return $this->getFaceCombinations();
    }

    /**
     * Two tiles single face matching test
     *
     * @param string    $face1          First Face to match
     * @param string    $face2          Second Face to match
     * @param string    $isMatching     Do the Faces match
     *
     * @dataProvider twoTilesProvider
     */
    public function testTwoTilesMatching($face1, $face2, $isMatching)
    {
        //Create starting tiles with all sides the first face (only matching one face at a time)
        $startingTile = Tile::createFromString($face1 . ':' . $face1 . ':' .$face1 . ':' .$face1 . ':' .$face1);

        //Creating a placing tile with all sides the second face (only matching one face at a time
        $placingTile =  Tile::createFromString($face2 . ':' . $face2 . ':' .$face2 . ':' .$face2 . ':' .$face2);

        $map = new Map($startingTile);

        //Attempt to place the tile in the North location. Matching start Tile North, Place Tile South
        $this->placeTiles($map, $placingTile, new Coordinate(0, 1), $isMatching);

        //Attempt to place the tile in the East location. Matching start Tile East, Place Tile West
        $this->placeTiles($map, $placingTile, new Coordinate(0, 1), $isMatching);

        //Attempt to place the tile in the South location. Matching start Tile South, Place Tile North
        $this->placeTiles($map, $placingTile, new Coordinate(0, 1), $isMatching);

        //Attempt to place the tile in the West location. Matching start Tile West, Place Tile East
        $this->placeTiles($map, $placingTile, new Coordinate(0, 1), $isMatching);
    }

    /**
     * Data Provider for the three tile two face test
     *
     * @return array
     */
    public function threeTilesProvider()
    {
        $testFaces = array();

        $faceSet1 = $this->getFaceCombinations();
        $faceSet2 = $this->getFaceCombinations();

        foreach($faceSet1 as $set1) {
            foreach($faceSet2 as $set2) {
                $testFaces[] = array(
                    $set1[0],
                    $set1[1],
                    $set2[0],
                    $set2[1],
                    ($set1[2] && $set2[2])
                );
            }
        }

        return $testFaces;
    }

    /**
     * Test Three tiles four faces matching
     *
     * @param string    $face1          First Face to match
     * @param string    $face2          Second Face to match
     * @param string    $face3          Third Face to match
     * @param string    $face4          Fourth Face to match
     * @param bool      $isMatching     Do all Faces match
     *
     * @dataProvider threeTilesProvider
     *
     * Visual representation of test, numbers represent face Ids, (X's don't matter)
                              -----------
                              |    4    |
                              |         |
                              |4   X   4|
                              |         |
                              |    4    |
                              -----------
                              -----------
                              |    3    |
                              |         |
                              |X   X   X|
                              |         |
                              |    2    |
                              -----------
    -----------  -----------  -----------  -----------  -----------
    |    4    |  |    X    |  |    1    |  |    X    |  |    4    |
    |         |  |         |  |         |  |         |  |         |
    |4   4   4|  |3   X   2|  |1   X   1|  |2   X   3|  |4   X   4|
    |         |  |         |  |         |  |         |  |         |
    |    4    |  |    X    |  |    1    |  |    X    |  |    4    |
    -----------  -----------  -----------  -----------  -----------
                              -----------
                              |    2    |
                              |         |
                              |X   X   X|
                              |         |
                              |    3    |
                              -----------
                              -----------
                              |    4    |
                              |         |
                              |4   X   4|
                              |         |
                              |    4    |
                              -----------
     */
    public function testThreeTilesMatching($face1, $face2, $face3, $face4, $isMatching)
    {
        $grass = Tile::TILE_TYPE_GRASS;

        //Create starting tiles with all sides the first face (only matching one face on this tile)
        $startingTile = Tile::createFromString("{$face1}:{$face1}:{$face1}:{$face1}:{$grass}");
        $startingCoordinate = new Coordinate(0, 0);

        //Create second tile with all sides the second face (only matching one face on this tile)
        $matchingTile =  Tile::createFromString("{$face4}:{$face4}:{$face4}:{$face4}:{$grass}");

        //Create tile to place matching 2 faces with starting and second tile
        $northPlacement = Tile::createFromString("{$face3}:{$grass}:{$face2}:{$grass}:{$grass}");
        $eastPlacement = Tile::createFromString("{$grass}:{$face3}:{$grass}:{$face2}:{$grass}");
        $southPlacement = Tile::createFromString("{$face2}:{$grass}:{$face3}:{$grass}:{$grass}");
        $westPlacement = Tile::createFromString("{$grass}:{$face2}:{$grass}:{$face3}:{$grass}");

        //Create Tiles array to add to Map
        $tiles = array(
            $startingCoordinate->toHash() => $startingTile,
            //Place Second tile in all matching locations
            (new Coordinate(0, 2))->toHash() => $matchingTile,
            (new Coordinate(2, 0))->toHash() => $matchingTile,
            (new Coordinate(0, -2))->toHash() => $matchingTile,
            (new Coordinate(-2, 0))->toHash() => $matchingTile,
        );

        // Create Map
        $map = new Map($startingTile);
        // Make Map properties accessible
        $mapReflection = new \ReflectionClass('Codecassonne\Map\Map');
        $tilesReflection = $mapReflection->getProperty('tiles');
        $tilesReflection->setAccessible(true);
        // Set the Bag Tiles
        $tilesReflection->setValue($map, $tiles);
        //Call Playable Positions for played positions
        $updatePlayableReflection = new \ReflectionMethod('Codecassonne\Map\Map', 'updatePlayablePositions');
        $updatePlayableReflection->setAccessible(true);
        $updatePlayableReflection->invoke($map, (new Coordinate(0, 2)));
        $updatePlayableReflection->invoke($map, (new Coordinate(2, 0)));
        $updatePlayableReflection->invoke($map, (new Coordinate(0, -2)));
        $updatePlayableReflection->invoke($map, (new Coordinate(-2, 0)));
        //Update the maps minimum bounding rectangle
        $minimumBoundingRectangleReflection = new \ReflectionMethod('Codecassonne\Map\Map', 'updateMinimumBoundingRectangle');
        $minimumBoundingRectangleReflection->setAccessible(true);
        $minimumBoundingRectangleReflection->invoke($map, (new Coordinate(-2 , -2)));
        $minimumBoundingRectangleReflection->invoke($map, (new Coordinate(2  , 2)));

        /**
         * Attempt to place the tile in the North location. Matching:
         * * Start Tile North, Place Tile South
         * * Second Tile South, Place Tile North
         */
        $this->placeTiles($map, $northPlacement, new Coordinate(0, 1), $isMatching);

        /**
         * Attempt to place the tile in the East location. Matching:
         * * Start Tile East, Place Tile West
         * * Second Tile West, Place Tile East
         */
        $this->placeTiles($map, $eastPlacement, new Coordinate(1, 0), $isMatching);

        /**
         * Attempt to place the tile in the South location. Matching:
         * * Start Tile South, Place Tile North
         * * Second Tile North, Place Tile South
         */
        $this->placeTiles($map, $southPlacement, new Coordinate(0, -1), $isMatching);

        /**
         * Attempt to place the tile in the West location. Matching:
         * * Start Tile West, Place Tile East
         * * Second Tile East, Place Tile West
         */
        $this->placeTiles($map, $westPlacement, new Coordinate(-1, 0), $isMatching);

    }

    /**
     * Data Provider for the four tiles, three face test
     *
     * @return array
     */
    public function fourTilesProvider()
    {
        $testFaces = array();

        $faceSet1 = $this->getFaceCombinations();
        $faceSet2 = $this->getFaceCombinations();
        $faceSet3 = $this->getFaceCombinations();

        foreach($faceSet1 as $set1) {
            foreach($faceSet2 as $set2) {
                foreach($faceSet3 as $set3) {
                    $testFaces[] = array(
                        $set1[0],
                        $set1[1],
                        $set2[0],
                        $set2[1],
                        $set3[0],
                        $set3[1],
                        ($set1[2] && $set2[2] && $set3[2])
                    );
                }
            }
        }

        return $testFaces;
    }

    /**
     * Test Four tiles six faces matching
     *
     * @param string    $face1          First Face to match
     * @param string    $face2          Second Face to match
     * @param string    $face3          Third Face to match
     * @param string    $face4          Fourth Face to match
     * @param string    $face5          Fifth Face to match
     * @param string    $face6          Sixth Face to match
     * @param bool      $isMatching     Do all Faces match
     *
     * @dataProvider fourTilesProvider
     *
     * Visual representation of test, numbers represent face Ids, letters represent Tiles, (X's don't matter)
    -----------  -----------  -----------
    |    X    |  |    X    |  |    X    |
    |         |  |         |  |         |
    |X   A   1|  |2   B   3|  |4   C   X|
    |         |  |         |  |         |
    |    4    |  |    5    |  |    1    |
    -----------  -----------  -----------
    -----------  -----------  -----------
    |    3    |  |    6    |  |    2    |
    |         |  |         |  |         |
    |X   D   5|  |6   E   6|  |5   F   X|
    |         |  |         |  |         |
    |    2    |  |    6    |  |    3    |
    -----------  -----------  -----------
    -----------  -----------  -----------
    |    1    |  |    5    |  |    4    |
    |         |  |         |  |         |
    |X   G   4|  |3   H   2|  |1   I   X|
    |         |  |         |  |         |
    |    X    |  |    X    |  |    X    |
    -----------  -----------  -----------
     */
    public function testFourTilesMatching($face1, $face2, $face3, $face4, $face5, $face6, $isMatching)
    {
        $grass = Tile::TILE_TYPE_GRASS;

        //Create Tiles to Test
        $tileA = Tile::createFromString("{$grass}:{$face1}:{$face4}:{$grass}:{$grass}");
        $tileB = Tile::createFromString("{$grass}:{$face3}:{$face5}:{$face2}:{$grass}");
        $tileC = Tile::createFromString("{$grass}:{$grass}:{$face1}:{$face4}:{$grass}");
        $tileD = Tile::createFromString("{$face3}:{$face5}:{$face2}:{$grass}:{$grass}");
        $tileE = Tile::createFromString("{$face6}:{$face6}:{$face6}:{$face6}:{$grass}");
        $tileF = Tile::createFromString("{$face2}:{$grass}:{$face3}:{$face5}:{$grass}");
        $tileG = Tile::createFromString("{$face1}:{$face4}:{$grass}:{$grass}:{$grass}");
        $tileH = Tile::createFromString("{$face5}:{$face2}:{$grass}:{$face3}:{$grass}");
        $tileI = Tile::createFromString("{$face4}:{$grass}:{$grass}:{$face1}:{$grass}");

        //Create Tiles array to add to Map
        $tiles = array(
            (new Coordinate(-1, 1))->toHash()   => $tileA,
            (new Coordinate(1 , 1))->toHash()   => $tileC,
            (new Coordinate(0 , 0))->toHash()   => $tileE,
            (new Coordinate(-1, -1))->toHash()  => $tileG,
            (new Coordinate(1 , -1))->toHash()  => $tileI,
        );

        //Create Map
        $map = new Map($tileE);
        //Make Map properties accessible
        $mapReflection = new \ReflectionClass('Codecassonne\Map\Map');
        $tilesReflection = $mapReflection->getProperty('tiles');
        $tilesReflection->setAccessible(true);
        //Get the Bag Tiles
        $tilesReflection->setValue($map, $tiles);
        //Call Playable Positions for played positions
        $updatePlayableReflection = new \ReflectionMethod('Codecassonne\Map\Map', 'updatePlayablePositions');
        $updatePlayableReflection->setAccessible(true);
        $updatePlayableReflection->invoke($map, (new Coordinate(-1, 1)));
        $updatePlayableReflection->invoke($map, (new Coordinate(1, 1)));
        $updatePlayableReflection->invoke($map, (new Coordinate(0, 0)));
        $updatePlayableReflection->invoke($map, (new Coordinate(-1, -1)));
        $updatePlayableReflection->invoke($map, (new Coordinate(1, -1)));
        //Update the maps minimum bounding rectangle
        $minimumBoundingRectangleReflection = new \ReflectionMethod('Codecassonne\Map\Map', 'updateMinimumBoundingRectangle');
        $minimumBoundingRectangleReflection->setAccessible(true);
        $minimumBoundingRectangleReflection->invoke($map, (new Coordinate(-1 , -1)));
        $minimumBoundingRectangleReflection->invoke($map, (new Coordinate(1  , 1)));

        //Test Placing Tile B, touching Tiles A, C, E
        $this->placeTiles($map, $tileB, new Coordinate(0, 1), $isMatching);

        //Test Placing Tile D, touching Tiles A, E, G
        $this->placeTiles($map, $tileD, new Coordinate(-1, 0), $isMatching);

        //Test Placing Tile F, touching Tiles C, E, I
        $this->placeTiles($map, $tileF, new Coordinate(1, 0), $isMatching);

        //Test Placing Tile H, touching Tiles G, E, I
        $this->placeTiles($map, $tileH, new Coordinate(0, -1), $isMatching);
    }

    /**
     * Data Provider for the five tiles, four face test
     *
     * @return array
     */
    public function fiveTilesProvider()
    {
        $testFaces = array();

        $faceSet1 = $this->getFaceCombinations();
        $faceSet2 = $this->getFaceCombinations();
        $faceSet3 = $this->getFaceCombinations();
        $faceSet4 = $this->getFaceCombinations();

        foreach($faceSet1 as $set1) {
            foreach($faceSet2 as $set2) {
                foreach($faceSet3 as $set3) {
                    foreach($faceSet4 as $set4) {
                        $testFaces[] = array(
                            $set1[0],
                            $set1[1],
                            $set2[0],
                            $set2[1],
                            $set3[0],
                            $set3[1],
                            $set4[0],
                            $set4[1],
                            ($set1[2] && $set2[2] && $set3[2] && $set4[2])
                        );
                    }
                }
            }
        }

        return $testFaces;
    }

    /**
     * Test Four tiles eight faces matching
     *
     * @param string    $face1          First Face to match
     * @param string    $face2          Second Face to match
     * @param string    $face3          Third Face to match
     * @param string    $face4          Fourth Face to match
     * @param string    $face5          Fifth Face to match
     * @param string    $face6          Sixth Face to match
     * @param string    $face7          Seventh Face to match
     * @param string    $face8          Eighth Face to match
     * @param bool      $isMatching     Do all Faces match
     *
     * @dataProvider fiveTilesProvider
     *
     * Visual representation of test, numbers represent face Ids, letters represent Tiles, (X's don't matter)

            -2           -1            0           1            2
        -----------  -----------  ----------- -----------  -----------
        |         |  |    1    |  |         | |    1    |  |         |
        |         |  |         |  |         | |         |  |         |
     2  |         |  |    A    |  |         | |    A    |  |         |
        |         |  |         |  |         | |         |  |         |
        |         |  |    1    |  |         | |    1    |  |         |
        -----------  -----------  ----------- -----------  -----------
        -----------  -----------  ----------- -----------  -----------
        |         |  |    2    |  |         | |    2    |  |         |
        |         |  |         |  |         | |         |  |         |
     1  |3   B   3|  |4   E   5|  |6   C   6| |5   F   4|  |3   B   3|
        |         |  |         |  |         | |         |  |         |
        |         |  |    7    |  |         | |    7    |  |         |
        -----------  -----------  ----------- -----------  -----------
        -----------  -----------  ----------- -----------  -----------
        |         |  |    8    |  |         | |    8    |  |         |
        |         |  |         |  |         | |         |  |         |
     0  |         |  |    D    |  |         | |    D    |  |         |
        |         |  |         |  |         | |         |  |         |
        |         |  |    8    |  |         | |    8    |  |         |
        -----------  -----------  ----------- -----------  -----------
        -----------  -----------  ----------- -----------  -----------
        |         |  |    7    |  |         | |    7    |  |         |
        |         |  |         |  |         | |         |  |         |
     -1 |3   B   3|  |4   G   5|  |6   C   6| |5   H   4|  |3   B   3|
        |         |  |         |  |         | |         |  |         |
        |         |  |    2    |  |         | |    2    |  |         |
        -----------  -----------  ----------- -----------  -----------
        -----------  -----------  ----------- -----------  -----------
        |         |  |    1    |  |         | |    1    |  |         |
        |         |  |         |  |         | |         |  |         |
     -2 |         |  |    A    |  |         | |    A    |  |         |
        |         |  |         |  |         | |         |  |         |
        |         |  |    1    |  |         | |    1    |  |         |
        -----------  -----------  ----------- -----------  -----------
     */
    public function testFiveTilesMatching($face1, $face2, $face3, $face4, $face5, $face6, $face7, $face8, $isMatching)
    {
        $grass = Tile::TILE_TYPE_GRASS;

        //Create Tiles to Test
        $tileA = Tile::createFromString("{$face1}:{$grass}:{$face1}:{$grass}:{$grass}");
        $tileB = Tile::createFromString("{$grass}:{$face3}:{$grass}:{$face3}:{$grass}");
        $tileC = Tile::createFromString("{$grass}:{$face6}:{$grass}:{$face6}:{$grass}");
        $tileD = Tile::createFromString("{$face8}:{$grass}:{$face8}:{$grass}:{$grass}");
        $tileE = Tile::createFromString("{$face2}:{$face5}:{$face7}:{$face4}:{$grass}");
        $tileF = Tile::createFromString("{$face2}:{$face4}:{$face7}:{$face5}:{$grass}");
        $tileG = Tile::createFromString("{$face7}:{$face5}:{$face2}:{$face4}:{$grass}");
        $tileH = Tile::createFromString("{$face7}:{$face4}:{$face2}:{$face5}:{$grass}");

        //Create Tiles array to add to Map
        $tiles = array(
            (new Coordinate(-1 , 2))->toHash()   => $tileA,
            (new Coordinate(1  , 2))->toHash()   => $tileA,

            (new Coordinate(-2 , 1))->toHash()   => $tileB,
            (new Coordinate(0  , 1))->toHash()   => $tileC,
            (new Coordinate(2  , 1))->toHash()   => $tileB,

            (new Coordinate(-1 , 0))->toHash()   => $tileD,
            (new Coordinate(1  , 0))->toHash()   => $tileD,

            (new Coordinate(-2 , -1))->toHash()   => $tileB,
            (new Coordinate(0  , -1))->toHash()   => $tileC,
            (new Coordinate(2  , -1))->toHash()   => $tileB,

            (new Coordinate(-1 , -2))->toHash()   => $tileA,
            (new Coordinate(1  , -2))->toHash()   => $tileA,
        );

        //Create Map
        $map = new Map(Tile::createFromString("{$grass}:{$grass}:{$grass}:{$grass}:{$grass}"));
        //Make Map properties accessible
        $mapReflection = new \ReflectionClass('Codecassonne\Map\Map');
        $tilesReflection = $mapReflection->getProperty('tiles');
        $tilesReflection->setAccessible(true);
        //Get the Bag Tiles
        $tilesReflection->setValue($map, $tiles);
        //Call Playable Positions for played positions
        $updatePlayableReflection = new \ReflectionMethod('Codecassonne\Map\Map', 'updatePlayablePositions');
        $updatePlayableReflection->setAccessible(true);
        $updatePlayableReflection->invoke($map, (new Coordinate(-1 , 2)));
        $updatePlayableReflection->invoke($map, (new Coordinate(1  , 2)));
        $updatePlayableReflection->invoke($map, (new Coordinate(-2 , 1)));
        $updatePlayableReflection->invoke($map, (new Coordinate(0  , 1)));
        $updatePlayableReflection->invoke($map, (new Coordinate(2  , 1)));
        $updatePlayableReflection->invoke($map, (new Coordinate(-1 , 0)));
        $updatePlayableReflection->invoke($map, (new Coordinate(1  , 0)));
        $updatePlayableReflection->invoke($map, (new Coordinate(-2 , -1)));
        $updatePlayableReflection->invoke($map, (new Coordinate(0  , -1)));
        $updatePlayableReflection->invoke($map, (new Coordinate(2  , -1)));
        $updatePlayableReflection->invoke($map, (new Coordinate(-1 , -2)));
        $updatePlayableReflection->invoke($map, (new Coordinate(1  , -2)));
        //Update the maps minimum bounding rectangle
        $minimumBoundingRectangleReflection = new \ReflectionMethod('Codecassonne\Map\Map', 'updateMinimumBoundingRectangle');
        $minimumBoundingRectangleReflection->setAccessible(true);
        $minimumBoundingRectangleReflection->invoke($map, (new Coordinate(-2 , -2)));
        $minimumBoundingRectangleReflection->invoke($map, (new Coordinate(2  , 2)));

        //Test Placing Tile E
        $this->placeTiles($map, $tileE, new Coordinate(-1, 1), $isMatching);

        //Test Placing Tile F
        $this->placeTiles($map, $tileF, new Coordinate(1, 1), $isMatching);

        //Test Placing Tile G
        $this->placeTiles($map, $tileG, new Coordinate(-1, -1), $isMatching);

        //Test Placing Tile H
        $this->placeTiles($map, $tileH, new Coordinate(1, -1), $isMatching);

    }

    /**
     * Test Placing tiles on an Empty Map
     *
     * @param Map           $map                Map to lay tiles on
     * @param Tile          $tile               Tile to lay on Map
     * @param Coordinate    $coordinate         Coordinates to Lay Tile
     * @param bool          $isMatching         Are Tile faces matching
     *
     * @dataProvider matchingTilesProvider
     */
    public function placeTiles(Map $map, Tile $tile, Coordinate $coordinate, $isMatching)
    {
        /** @var \Exception $exception */
        $exception = null;

        try {
            //Attempt to place tile
            $map->place($tile, $coordinate);
        } catch (Exception $e) {
            //Catch any Exception
            $exception = $e;
        }

        if ($isMatching) {
            //If the faces match assert no Exception
            $this->assertNull($exception);
        } else {
            $this->assertInstanceOf('Exception', $exception);
            //If the faces do not match assert Exception
            $this->assertSame('Invalid tile placement', $exception->getMessage());
        }
    }
}
