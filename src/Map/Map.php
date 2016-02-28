<?php

namespace Codecassonne\Map;

use Codecassonne\Tile\Tile;

class Map {

    /** @var  Tile[] Tiles to represent positioning on the map */
    private $tiles = array();

    /** @var  Coordinate[] Playable positions on the map */
    private $playablePositions = array();

    /** @var  Coordinate Bottom left coordinate of maps Minimum Bounding Rectangle */
    private $bottomLeft = 0;

    /** @var  Coordinate Top right coordinate of maps Minimum Bounding Rectangle */
    private $topRight = 0;

    /**
     * Construct the Map
     *
     * @param Tile $startingTile The game starting tile
     */
    public function __construct(Tile $startingTile)
    {
        $this->tiles = array();

        //Set the Map starting coordinate
        $startingCoordinate = new Coordinate(0, 0);
        $this->bottomLeft = $startingCoordinate;
        $this->topRight = $startingCoordinate;

        //Place the starting tile
        $this->addTile($startingTile, $startingCoordinate);
    }

    /**
     * Attempt to place a tile on the map
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

        $this->addTile($tile, $coordinate);
    }

    /**
     * Add tile to the map tiles and update map details
     *
     * @param Tile          $tile       Tile to lay
     * @param Coordinate    $coordinate Coordinate to lay place in
     *
     * @throws \Exception
     */
    private function addTile(Tile $tile, Coordinate $coordinate)
    {
        $this->tiles[$coordinate->toHash()] = $tile;
        $this->updateMinimumBoundingRectangle($coordinate);
        $this->updatePlayablePositions($coordinate);
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
     * Get a random Playable Position
     * @todo Remove this function it is only temporary while the logic is done here, a player would eventually do this
     *
     * @return Coordinate
     */
    public function getPlayablePosition()
    {
        $playablePositions = $this->playablePositions;
        shuffle($playablePositions);

        $position = array_shift($playablePositions);
        return $position;
    }

    /**
     * Update the playable positions on the map based based on a tile laid in a new coordinate
     *
     * @param Coordinate $coordinate Coordinate to update Maps Minimum Bounding Rectangle With
     */
    private function updatePlayablePositions(Coordinate $coordinate)
    {
        // Remove laid coordinate from playable positions
        if(isset($this->playablePositions[$coordinate->toHash()])) {
            unset($this->playablePositions[$coordinate->toHash()]);
        }

        /** @var Coordinate $touchingCoordinate */
        foreach($coordinate->getTouchingCoordinates() as $touchingCoordinate) {
            if(
                !isset($this->playablePositions[$touchingCoordinate->toHash()]) &&
                !$this->isOccupied($touchingCoordinate)
            ) {
                $this->playablePositions[$touchingCoordinate->toHash()] = $touchingCoordinate;
            }
        }
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
        if(!$this->isPlayablePosition($coordinate)) {
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

    /*
     * Check if a coordinate is in the playable positions array
     *
     * @param Coordinate $coordinate    Position to check is occupied
     *
     * @returns bool
     */
    private function isPlayablePosition(Coordinate $coordinate)
    {
        return array_key_exists($coordinate->toHash(), $this->playablePositions);
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