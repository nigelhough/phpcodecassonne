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
}
