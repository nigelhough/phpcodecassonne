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
    private function generateBag($tileCount) {
        $bag = new Bag();
        for ($i = 0; $i < $tileCount; $i++) {
            $bag->put(new Tile());
        }

        return $bag;
    }


}