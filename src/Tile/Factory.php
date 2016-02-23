<?php

namespace Codecassonne\Tile;

/**
 * Factory to Create Tile
 */
class Factory
{
    /**
     * Create a Tile
     *
     * @param Faces $tileFaces  The faces on the tile
     *
     * @return Tile
     */
    public function create(Faces $tileFaces)
    {
        //Create new Tile
        return new Tile($tileFaces->north, $tileFaces->east, $tileFaces->south, $tileFaces->west, $tileFaces->center);
    }
}
