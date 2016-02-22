<?php

namespace Codecassonne\Tile;

/**
 * Class Bag
 */
class Bag
{
    /** @var array An array of Tiles */
    private $tiles = array();

    /**
     * Put a Tile in the bag
     *
     * @param Tile $tile Tile to put in the bag
     */
    public function put(Tile $tile)
    {
        $this->tiles[] = $tile;
    }

    /**
     * Draw a Tile from the bag
     *
     * @return Tile
     *
     * @throws \Exception
     */
    public function drawFrom()
    {
        if($this->isEmpty()) {
            throw new \Exception("The bag is empty");
        }
        return array_pop($this->tiles);
    }

    /**
     * Check if there are any tiles in the bag left
     *
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->tiles);
    }

    /**
     * Get the number of tiles in the bag
     *
     * @return int
     */
    public function getTileCount()
    {
        return count($this->tiles);
    }
}