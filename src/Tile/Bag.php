<?php
declare(strict_types=1);

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
        // Add a clone of tile to bag so it can't be modified externally
        $this->tiles[] = clone $tile;
    }

    /**
     * Draw a Tile from the bag
     *
     * @return Tile
     *
     * @throws Exception\EmptyBag
     */
    public function drawFrom()
    {
        if ($this->isEmpty()) {
            throw new Exception\EmptyBag("The bag is empty");
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

    /**
     * Shuffle the tiles in the bag
     * Guarantees the tiles will come back in a different order
     */
    public function shuffle()
    {
        // If there is less than 2 tiles just return without action
        if (count($this->tiles) <= 1) {
            return;
        }

        // If the array only has 2 elements, just reverse it
        if (count($this->tiles) == 2) {
            $this->tiles = array_reverse($this->tiles);
            return;
        }

        //If not shuffle the tiles until they are different until the original
        $unshuffledTiles = $this->tiles;
        while ($unshuffledTiles === $this->tiles) {
            shuffle($this->tiles);
        }
    }
}
