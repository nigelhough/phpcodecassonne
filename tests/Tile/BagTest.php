<?php

namespace Codecassonne\Tile;

/**
 * Class Bag
 */
class BagTest extends \PHPUnit\Framework\TestCase
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
     * Test Tile Quantity functions isEmpy and getTileCount methods
     *
     * @param Bag   $bag        Bag to test
     * @param bool  $isEmpty    Is the bag expected to be empty
     * @param int   $tileCount  No of tiles expected in the bag
     *
     * @dataProvider bagProvider
     */
    public function testTileQuantity(Bag $bag, $isEmpty, $tileCount)
    {
        $this->assertEquals($bag->isEmpty(), $isEmpty);
        $this->assertEquals($bag->getTileCount(), $tileCount);
    }

    /**
     * Test put and drawFrom methods
     *
     * @param Bag   $bag        Bag of tiles to put and draw from
     * @param bool  $isEmpty    Is the bag expected to be empty at the end
     * @param int   $tileCount  The starting Tile count
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
        $this->expectException('Codecassonne\Tile\Exception\EmptyBag');
        $emptyBag->drawFrom();
    }

    /**
     * Data provider for the shuffle test
     *
     * @return array
     */
    public function shuffleProvider()
    {
        return array(
            array(0, true),
            array(1, true),
            array(2, false),
            array(3, false),
        );
    }

    /**
     * Test shuffling the bag of tiles, function guarantees a different order for arrays with a length >= 2
     * Checks the array length and object Ids to ensure objects are not altered in the function
     *
     * @param int   $bagSize                Bag Size to test
     * @param bool  $expectedMatchingOrder  Are tiles expected to be in the same order
     *
     * @dataProvider shuffleProvider
     */
    public function testBagShuffle($bagSize, $expectedMatchingOrder)
    {
        $bagReflection = new \ReflectionClass('Codecassonne\Tile\Bag');
        $tilesReflection = $bagReflection->getProperty('tiles');
        $tilesReflection->setAccessible(true);

        //Create a bag of tiles
        $bag = $this->generateBag($bagSize);

        //Get the Bag Tiles
        $unshuffledTiles = $tilesReflection->getValue($bag);
        $unshuffledTileHashes = array_map(function($tile) { return spl_object_hash($tile);}, $unshuffledTiles);

        //Shuffle Bag
        $bag->shuffle();

        //Get the Shuffled Tiles
        $shuffledTiles = $tilesReflection->getValue($bag);
        $shuffledTileHashes = array_map(function($tile) { return spl_object_hash($tile);}, $shuffledTiles);

        //Assert the bag size is the same
        $this->assertEquals(count($unshuffledTiles), count($shuffledTiles));

        if($expectedMatchingOrder) {
            //Assert the shuffled tiles is in the same order as the un-shuffled
            $this->assertSame($unshuffledTileHashes, $shuffledTileHashes);
        } else {
            //Assert the shuffled tiles is not the same order as the un-shuffled
            $this->assertNotSame($unshuffledTileHashes, $shuffledTileHashes);
        }

        //Sort the Tile hashes
        sort($shuffledTileHashes);
        sort($unshuffledTileHashes);

        //Assert the Tile object hashes are the same once sorted, the original tiles haven't been affected
        $this->assertSame($unshuffledTileHashes, $shuffledTileHashes);


    }
}