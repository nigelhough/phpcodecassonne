<?php

namespace Codecassonne\Map;


use Codecassonne\Tile\Tile;

class Map {

    /** @var  array two dimensional array of Tiles to represent positioning on the map */
    private $tiles;

    public function __construct()
    {
        $this->tiles = array();
    }

    /**
     * Place a tile on the map
     *
     * @param Tile $tile
     * @param $xCoord
     * @param $yCoord
     *
     * @throws \Exception
     */
    public function place(Tile $tile, $xCoord, $yCoord)
    {
        if(!$this->isValidPlacement($tile, $xCoord, $yCoord)) {
            throw new \Exception("Invalid tile placement");
        }

        if(!array_key_exists($xCoord, $this->tiles)) {
            $this->tiles[$xCoord] = array();
        }

        $this->tiles[$xCoord][$yCoord] = $tile;
    }

    /**
     * Check if placing $tile at position ($xCoord, $yCoord) is valid
     *
     * @param Tile $tile
     * @param $xCoord
     * @param $yCoord
     *
     * @return bool
     */
    private function isValidPlacement(Tile $tile, $xCoord, $yCoord)
    {
        if($this->isOccupied($xCoord, $yCoord)) {
            return false;
        }

        // @TODO validate placement

        return true;
    }

    /**
     * Check if position ($xCoord, $yCoord) is occupied
     *
     * @param $xCoord
     * @param $yCoord
     *
     * @return bool
     */
    private function isOccupied($xCoord, $yCoord)
    {
        if(!array_key_exists($xCoord, $this->tiles)) {
            return false;
        }
        return array_key_exists($yCoord, $this->tiles[$xCoord]);
    }

    /**
     * Get the number of rows
     *
     * @return int
     */
    private function getRowNumber()
    {
        return max(array_keys($this->tiles)) + 1;
    }

    /**
     * Get the number of columns
     *
     * @return int
     */
    private function getColumnNumber()
    {
        $max = 0;
        foreach($this->tiles as $row) {
            $max = max(count($row), $max);
        }
        return $max;
    }

    /**
     * Draw current state of the map
     */
    public function draw()
    {
        $rowNumber = $this->getRowNumber();
        $columnNumber = $this->getColumnNumber();

        for($i = 0; $i < $rowNumber; $i++) {
            for($renderTemp = 7; $renderTemp > 0; $renderTemp--) {
                for($j = 0; $j < $columnNumber; $j++) {

                    if(!$this->isOccupied($i, $j)) {
                        echo "             ";
                        continue;
                    }

                    if(in_array($renderTemp, array(1,7))) {
                        echo " ----------- ";
                        continue;
                    }

                    $t = $this->tiles[$i][$j];
                    switch($renderTemp) {
                        case 6: echo " |    {$t->getNorth()}    | "; break;
                        case 4: echo " |{$t->getWest()}   {$t->getCenter()}   {$t->getEast()}| "; break;
                        case 2: echo " |    {$t->getSouth()}    | "; break;
                        default: echo " |         | ";
                    }
                }
                echo PHP_EOL;
            }
        }
        echo PHP_EOL;
    }
}