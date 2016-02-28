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
     * Data Provider for the matching tiles test
     *
     * @return array
     */
    public function OLDmatchingTilesProvider()
    {
        return array(
            /** Attempt Matching two grass tiles on 1 side */
            array(
                new Map(Tile::createFromString('G:G:G:G:G')),
                Tile::createFromString('G:G:G:G:G'),
                new Coordinate(0, 1),
                '',
            ),
            /** Attempt Matching two city tiles on 1 side */
            array(
                new Map(Tile::createFromString('C:C:C:C:C')),
                Tile::createFromString('C:C:C:C:C'),
                new Coordinate(0, 1),
                '',
            ),
            /** Attempt Matching twp road tiles on 1 side */
            array(
                new Map(Tile::createFromString('R:R:R:R:R')),
                Tile::createFromString('R:R:R:R:R'),
                new Coordinate(0, 1),
                '',
            ),
            /** Attempt Matching grass and road tiles on 1 side */
            array(
                new Map(Tile::createFromString('G:G:G:G:G')),
                Tile::createFromString('R:R:R:R:R'),
                new Coordinate(0, 1),
                'Exception',
            ),
            /** Attempt Matching grass and city tiles on 1 side */
            array(
                new Map(Tile::createFromString('G:G:G:G:G')),
                Tile::createFromString('C:C:C:C:C'),
                new Coordinate(0, 1),
                'Exception',
            ),
            /** Attempt Matching road and city tiles on 1 side */
            array(
                new Map(Tile::createFromString('R:R:R:R:R')),
                Tile::createFromString('C:C:C:C:C'),
                new Coordinate(0, 1),
                'Exception',
            ),
            /** Attempt Matching one side of placing tile */
            array(
                new Map(Tile::createFromString('G:G:G:G:G')),
                Tile::createFromString('R:R:R:G:R'),
                new Coordinate(0, 1),
                '',
            ),
            /** Attempt Matching one side of placing tile wrong Orientation */
            array(
                new Map(Tile::createFromString('G:G:G:G:G')),
                Tile::createFromString('R:R:G:R:R'),
                new Coordinate(0, 1),
                'Exception',
            ),
        );
    }

    /**
     * Data Provider for the matching tiles test
     *
     * @return array
     */
    public function mapProvider()
    {
        $map = new Map(Tile::createFromString('G:R:C:G:G'));
        $map->render();

        echo " ================================================== " . PHP_EOL . PHP_EOL;

        $map = new Map(Tile::createFromString('C:R:C:G:G'));
        $map->place(Tile::createFromString('G:R:C:G:R'), new Coordinate(0, 2));
        $map->place(Tile::createFromString('G:R:C:G:C'), new Coordinate(2, 2));
        $map->place(Tile::createFromString('C:R:C:G:R'), new Coordinate(2, 0));
        $map->render();

        echo " ================================================== " . PHP_EOL . PHP_EOL;

        $map = new Map(Tile::createFromString('C:R:C:G:G'));
        $map->place(Tile::createFromString('G:R:C:G:R'), new Coordinate(1, 0));
        $map->place(Tile::createFromString('G:R:C:G:C'), new Coordinate(0, 1));
        $map->place(Tile::createFromString('C:R:C:G:R'), new Coordinate(-1, 0));
        $map->place(Tile::createFromString('C:R:C:G:R'), new Coordinate(0, -1));
        $map->render();

        echo " ================================================== " . PHP_EOL . PHP_EOL;

        $map = new Map(Tile::createFromString('C:R:C:G:G'));
        $map->place(Tile::createFromString('G:R:C:G:R'), new Coordinate(1, 1));
        $map->place(Tile::createFromString('G:R:C:G:C'), new Coordinate(2, 0));
        $map->place(Tile::createFromString('C:R:C:G:R'), new Coordinate(1, -1));
        $map->render();

        exit;
    }

    /**
     * Provides the tile faces that can be matched
     *
     * @return array
     */
    public function tileFaces()
    {
        return array(
            Tile::TILE_TYPE_GRASS,
            Tile::TILE_TYPE_CITY,
            Tile::TILE_TYPE_ROAD
        );
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

        //Create Map
        $map = new Map($startingTile);
        //Make Map properties accessible
        $mapReflection = new \ReflectionClass('Codecassonne\Map\Map');
        $tilesReflection = $mapReflection->getProperty('tiles');
        $tilesReflection->setAccessible(true);
        //Get the Bag Tiles
        $tilesReflection->setValue($map, $tiles);

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
