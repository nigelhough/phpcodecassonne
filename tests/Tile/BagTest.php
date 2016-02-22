<?php

namespace Codecassonne\Tile;

/**
 * Class Bag
 */
class BagTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Generate a bag with $tileCount number of Tiles in it
     *
     * @param int $tileCount number of Tiles in the generated Bag
     *
     * @return Bag
     */
    private function generateBag($tileCount)
    {
        $bag = new Bag();
        for ($i = 0; $i < $tileCount; $i++) {
            $bag->put(new Tile(
                Tile::TILE_TYPE_ROAD,
                Tile::TILE_TYPE_ROAD,
                Tile::TILE_TYPE_ROAD,
                Tile::TILE_TYPE_ROAD,
                Tile::TILE_TYPE_GRASS
            ));
        }

        return $bag;
    }

    /**
     * Data provider for BagTests
     *
     * @return array( array(Bag, isEmpty, tileCount) )
     */
    public function bagProvider()
    {
        return array(
            array($this->generateBag(0), true, 0),
            array($this->generateBag(5), false, 5)
        );
    }

    /**
     * Test isEmpy method
     *
     * @dataProvider bagProvider
     */
    public function testIsEmpty(Bag $bag, $isEmpty, $tileCount)
    {
        $this->assertEquals($bag->isEmpty(), $isEmpty);
    }

    /**
     * Test getTileCount method
     *
     * @dataProvider bagProvider
     */
    public function testGetTileCount(Bag $bag, $isEmpty, $tileCount)
    {
        $this->assertEquals($bag->getTileCount(), $tileCount);
    }

    /**
     * Test put and drawFrom methods
     *
     * @dataProvider bagProvider
     */
    public function testPutAndDrawFrom(Bag $bag, $isEmpty, $tileCount)
    {
        $tile = new Tile(
            Tile::TILE_TYPE_CITY,
            Tile::TILE_TYPE_CITY,
            Tile::TILE_TYPE_ROAD,
            Tile::TILE_TYPE_ROAD,
            Tile::TILE_TYPE_GRASS
        );

        // put a new tile in the bag
        $bag->put($tile);

        // assert that tileCount increased by one
        $this->assertEquals($bag->getTileCount(), $tileCount+1);

        // assert that the bag is not empty, even if it was before the new tile
        $this->assertEquals($bag->isEmpty(), false);

        // draw a tile from the bag and check that we get the same tile we just put in (the bag is a LIFO stack)
        $this->assertEquals($bag->drawFrom(),$tile);

        // assert that after drawing the tileCount is back to what it was before we put a tile in
        $this->assertEquals($bag->getTileCount(), $tileCount);

        // assert that the bag is empty now if it was empty before putting in then drawing a tile
        $this->assertEquals($bag->isEmpty(), $isEmpty);
    }


    /**
     * Test drawFrom an empty bag
     */
    public function testDrawFromEmpty()
    {
        $emptyBag = $this->generateBag(0);
        $this->setExpectedException("Exception");
        $emptyBag->drawFrom();
    }
}