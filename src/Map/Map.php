<?php

namespace Codecassonne\Map;

use Codecassonne\Tile\Tile;

class Map {

    /** @var  array Tiles to represent positioning on the map */
    private $tiles;

    /** @var  Coordinate Bottom left coordinate of maps Minimum Bounding Rectangle */
    private $bottomLeft;

    /** @var  Coordinate Top right coordinate of maps Minimum Bounding Rectangle */
    private $topRight;

    /**
     * Construct the Map
     *
     * @param Tile $startingTile    The game starting tile
     */
    public function __construct(Tile $startingTile)
    {
        $this->tiles = array();

        //Set the Map starting coordinate
        $startingCoordinate = new Coordinate(0, 0);
        $this->bottomLeft = $startingCoordinate;
        $this->topRight = $startingCoordinate;

        //Place the starting tile
        $this->place($startingTile, $startingCoordinate);
    }

    /**
     * Place a tile on the map
     *
     * @param Tile          $tile       Tile to lay
     * @param Coordinate    $coordinate Coordinate to lay place in
     *
     * @throws \Exception
     */
    public function place(Tile $tile, Coordinate $coordinate)
    {
        if(!$this->isValidPlacement($tile, $coordinate)) {
            throw new \Exception("Invalid tile placement");
        }

        $this->tiles[$coordinate->toHash()] = $tile;
        $this->updateMinimumBoundingRectangle($coordinate);
    }

    /**
     * Update the Maps Minimum Bounding Rectangle with a new Coordinate
     *
     * @param Coordinate $coordinate Coordinate to update Maps Minimum Bounding Rectangle With
     */
    private function updateMinimumBoundingRectangle(Coordinate $coordinate)
    {
        //Update the Bottom Left Coordinate of the map
        $this->bottomLeft = new Coordinate(
            min(array($coordinate->getX(), $this->bottomLeft->getX())),
            min(array($coordinate->getY(), $this->bottomLeft->getY()))
        );

        //Update the Top Right Coordinate of the map
        $this->topRight = new Coordinate(
            max(array($coordinate->getX(), $this->topRight->getX())),
            max(array($coordinate->getY(), $this->topRight->getY()))
        );
    }

    /**
     * Check if placing $tile at position is valid
     *
     * @param Tile          $tile       Tile to lay
     * @param Coordinate    $coordinate Coordinate to check is valid
     *
     * @return bool
     */
    private function isValidPlacement(Tile $tile, Coordinate $coordinate)
    {
        if($this->isOccupied($coordinate)) {
            return false;
        }

        // @TODO validate tile placement

        return true;
    }

    /**
     * Check if position is occupied
     *
     * @param Coordinate $coordinate    Position to check is occupied
     *
     * @return bool
     */
    private function isOccupied(Coordinate $coordinate)
    {
        return array_key_exists($coordinate->toHash(), $this->tiles);
    }
    
    /**
     * Draw current state of the map
     */
    public function render()
    {
        for($x = $this->bottomLeft->getX(); $x <= $this->topRight->getX(); $x++) {

            for($renderTemp = 7; $renderTemp > 0; $renderTemp--) {

                for($y = $this->bottomLeft->getY(); $y <= $this->topRight->getY(); $y++) {

                    $currentCoordinate = new Coordinate($x, $y);

                    if(!$this->isOccupied($currentCoordinate)) {
                        echo "             ";
                        continue;
                    }

                    if(in_array($renderTemp, array(1,7))) {
                        echo " ----------- ";
                        continue;
                    }

                    $currentTile = $this->tiles[$currentCoordinate->toHash()];
                    switch($renderTemp) {
                        case 6: echo " |    {$currentTile->getNorth()}    | "; break;
                        case 4: echo " |{$currentTile->getWest()}   {$currentTile->getCenter()}   {$currentTile->getEast()}| "; break;
                        case 2: echo " |    {$currentTile->getSouth()}    | "; break;
                        default: echo " |         | ";
                    }
                }
                echo PHP_EOL;
            }
        }
        echo PHP_EOL;
    }
}