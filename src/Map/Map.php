<?php

namespace Codecassonne\Map;

use Codecassonne\Tile\Tile;

class Map {

    /** @var  Tile[] Tiles to represent positioning on the map */
    private $tiles;

    /** @var  Coordinate[] Playable positions on the map */
    private $playablePositions;

    /** @var  Coordinate Bottom left coordinate of maps Minimum Bounding Rectangle */
    private $bottomLeft;

    /** @var  Coordinate Top right coordinate of maps Minimum Bounding Rectangle */
    private $topRight;

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
        //return array_shift($this->playablePositions);

        $playablePositions = $this->playablePositions;
        shuffle($playablePositions);

        $position = array_shift($playablePositions);
        return $position;

        return array_shift($playablePositions);
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

        // Add offset positions to playable positions
        $northCoordinate = new Coordinate($coordinate->getX(), $coordinate->getY() + 1);
        $eastCoordinate = new Coordinate($coordinate->getX() + 1, $coordinate->getY());
        $southCoordinate = new Coordinate($coordinate->getX(), $coordinate->getY() - 1);
        $westCoordinate = new Coordinate($coordinate->getX() - 1, $coordinate->getY());

        if(!isset($this->playablePositions[$northCoordinate->toHash()]) && !$this->isOccupied($northCoordinate)) {
            $this->playablePositions[$northCoordinate->toHash()] = $northCoordinate;
        }
        if(!isset($this->playablePositions[$eastCoordinate->toHash()]) && !$this->isOccupied($eastCoordinate)) {
            $this->playablePositions[$eastCoordinate->toHash()] = $eastCoordinate;
        }
        if(!isset($this->playablePositions[$southCoordinate->toHash()]) && !$this->isOccupied($southCoordinate)) {
            $this->playablePositions[$southCoordinate->toHash()] = $southCoordinate;
        }
        if(!isset($this->playablePositions[$westCoordinate->toHash()]) && !$this->isOccupied($westCoordinate)) {
            $this->playablePositions[$westCoordinate->toHash()] = $westCoordinate;
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