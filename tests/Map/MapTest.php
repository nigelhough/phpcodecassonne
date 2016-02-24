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
        if($expectedException) {
            $this->setExpectedException('Exception');
        }

        //Dummy Tile
        $tile = Tile::createFromString(Tile::TILE_TYPE_GRASS.":".Tile::TILE_TYPE_GRASS.":".Tile::TILE_TYPE_GRASS.":".Tile::TILE_TYPE_GRASS.":".Tile::TILE_TYPE_GRASS);

        $map = new Map($tile);

        $map->place($tile, $placeCoordinate1);
        $map->place($tile, $placeCoordinate2);
    }

    public function renderTestProvider()
    {
        return array(
            array(
                Tile::createFromString(Tile::TILE_TYPE_GRASS.":".Tile::TILE_TYPE_ROAD.":".Tile::TILE_TYPE_CITY.":".Tile::TILE_TYPE_ROAD.":".Tile::TILE_TYPE_ROAD),
                " ----------- " . PHP_EOL .
                " |    G    | ".PHP_EOL .
                " |         | ".PHP_EOL .
                " |R   R   R| ".PHP_EOL .
                " |         | ".PHP_EOL .
                " |    C    | ".PHP_EOL .
                " ----------- ".PHP_EOL .
                "".PHP_EOL .
                "",
            ),
            array(
                Tile::createFromString(Tile::TILE_TYPE_GRASS.":".Tile::TILE_TYPE_GRASS.":".Tile::TILE_TYPE_GRASS.":".Tile::TILE_TYPE_GRASS.":".Tile::TILE_TYPE_GRASS),
                " ----------- " . PHP_EOL .
                " |    G    | ".PHP_EOL .
                " |         | ".PHP_EOL .
                " |G   G   G| ".PHP_EOL .
                " |         | ".PHP_EOL .
                " |    G    | ".PHP_EOL .
                " ----------- ".PHP_EOL .
                "".PHP_EOL .
                "",
            ),
            array(
                Tile::createFromString(Tile::TILE_TYPE_ROAD.":".Tile::TILE_TYPE_ROAD.":".Tile::TILE_TYPE_ROAD.":".Tile::TILE_TYPE_ROAD.":".Tile::TILE_TYPE_ROAD),
                " ----------- " . PHP_EOL .
                " |    R    | ".PHP_EOL .
                " |         | ".PHP_EOL .
                " |R   R   R| ".PHP_EOL .
                " |         | ".PHP_EOL .
                " |    R    | ".PHP_EOL .
                " ----------- ".PHP_EOL .
                "".PHP_EOL .
                "",
            ),
            array(
                Tile::createFromString(Tile::TILE_TYPE_CITY.":".Tile::TILE_TYPE_CITY.":".Tile::TILE_TYPE_CITY.":".Tile::TILE_TYPE_CITY.":".Tile::TILE_TYPE_CITY),
                " ----------- " . PHP_EOL .
                " |    C    | ".PHP_EOL .
                " |         | ".PHP_EOL .
                " |C   C   C| ".PHP_EOL .
                " |         | ".PHP_EOL .
                " |    C    | ".PHP_EOL .
                " ----------- ".PHP_EOL .
                "".PHP_EOL .
                "",
            ),
            array(
                Tile::createFromString(Tile::TILE_TYPE_CITY.":".Tile::TILE_TYPE_CITY.":".Tile::TILE_TYPE_CITY.":".Tile::TILE_TYPE_CITY.":".Tile::TILE_TYPE_GRASS),
                " ----------- " . PHP_EOL .
                " |    C    | ".PHP_EOL .
                " |         | ".PHP_EOL .
                " |C   G   C| ".PHP_EOL .
                " |         | ".PHP_EOL .
                " |    C    | ".PHP_EOL .
                " ----------- ".PHP_EOL .
                "".PHP_EOL .
                "",
            ),
        );
    }

    /**
     * Test Map Rendering function
     *
     * @param Tile      $startingTile       Starting Tile on Map
     * @param string    $expectedOutput     Expected Rendered Map
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
        $map = new Map(Tile::createFromString(Tile::TILE_TYPE_GRASS.":".Tile::TILE_TYPE_ROAD.":".Tile::TILE_TYPE_CITY.":".Tile::TILE_TYPE_ROAD.":".Tile::TILE_TYPE_ROAD));

        //Add Tile North of Starting Tile
        $map->place(
            Tile::createFromString(Tile::TILE_TYPE_CITY.":".Tile::TILE_TYPE_ROAD.":".Tile::TILE_TYPE_GRASS.":".Tile::TILE_TYPE_ROAD.":".Tile::TILE_TYPE_ROAD),
            new Coordinate(0, 1)
        );

        //Add Tile East of second Tile
        $map->place(
            Tile::createFromString(Tile::TILE_TYPE_GRASS.":".Tile::TILE_TYPE_ROAD.":".Tile::TILE_TYPE_GRASS.":".Tile::TILE_TYPE_ROAD.":".Tile::TILE_TYPE_ROAD),
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
     * @param Map $map  Map to render
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
}
