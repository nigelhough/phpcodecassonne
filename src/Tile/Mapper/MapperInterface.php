<?php

namespace Codecassonne\Tile\Mapper;

use Codecassonne\Tile\Tile;

/**
 * Interface MapperInterface
 *
 * @package Codecassonne\Tile\Mapper
 */
interface MapperInterface
{
    /**
     * Get All Tiles
     *
     * @returns Tile[]
     */
    public function findAll();

}
