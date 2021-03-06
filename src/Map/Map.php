<?php
declare(strict_types = 1);

namespace Codecassonne\Map;

use Codecassonne\Tile\Tile;

/**
 * Class that represents a game map
 */
class Map
{
    /** @var Tile[] Tiles to represent positioning on the map */
    private $tiles = [];

    /** @var Coordinate[] Playable positions on the map */
    private $playablePositions = [];

    /** @var Coordinate Bottom left coordinate of maps Minimum Bounding Rectangle */
    private $bottomLeft;

    /** @var Coordinate Top right coordinate of maps Minimum Bounding Rectangle */
    private $topRight;

    /**
     * Construct the Map
     *
     * @param Tile $startingTile The game starting tile
     */
    public function __construct(Tile $startingTile)
    {
        $this->tiles = [];

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
     * @param Tile       $tile       Tile to lay
     * @param Coordinate $coordinate Coordinate to lay place in
     *
     * @throws \Exception
     */
    public function place(Tile $tile, Coordinate $coordinate)
    {
        if (!$this->isValidPlacement($tile, $coordinate)) {
            throw new Exception\InvalidTilePlacement("Invalid tile placement");
        }

        $this->addTile($tile, $coordinate);
    }

    /**
     * Look at a tile in a coordinate
     * Returns a copy so original tile can't be manipulated
     *
     * @param Coordinate $coordinate Position to look at
     *
     * @return Tile
     * @throws Exception\UnoccupiedCoordinate
     */
    public function look(Coordinate $coordinate)
    {
        if (!$this->isOccupied($coordinate)) {
            throw new Exception\UnoccupiedCoordinate('Can\'t fetch tile from unoccupied location');
        }
        return clone $this->tiles[$coordinate->toHash()];
    }

    /**
     * Add tile to the map tiles and update map details
     *
     * @param Tile       $tile       Tile to lay
     * @param Coordinate $coordinate Coordinate to lay place in
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
     * Check if position is occupied
     *
     * @param Coordinate $coordinate Position to check is occupied
     *
     * @return bool
     */
    public function isOccupied(Coordinate $coordinate)
    {
        return array_key_exists($coordinate->toHash(), $this->tiles);
    }

    /**
     * Get a the Playable Position
     *
     * @todo Restrict this so players have to workout there own playable positions
     *
     * @return Coordinate[]
     */
    public function getPlayablePositions()
    {
        return $this->playablePositions;
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
            min([$coordinate->getX(), $this->bottomLeft->getX()]),
            min([$coordinate->getY(), $this->bottomLeft->getY()])
        );

        //Update the Top Right Coordinate of the map
        $this->topRight = new Coordinate(
            max([$coordinate->getX(), $this->topRight->getX()]),
            max([$coordinate->getY(), $this->topRight->getY()])
        );
    }

    /**
     * Update the playable positions on the map based based on a tile laid in a new coordinate
     *
     * @param Coordinate $coordinate Coordinate to update Maps Minimum Bounding Rectangle With
     */
    private function updatePlayablePositions(Coordinate $coordinate)
    {
        // Remove laid coordinate from playable positions
        if (isset($this->playablePositions[$coordinate->toHash()])) {
            unset($this->playablePositions[$coordinate->toHash()]);
        }

        /** @var Coordinate $touchingCoordinate */
        foreach ($coordinate->getTouchingCoordinates() as $touchingCoordinate) {
            if (!isset($this->playablePositions[$touchingCoordinate->toHash()])
                && !$this->isOccupied($touchingCoordinate)
            ) {
                $this->playablePositions[$touchingCoordinate->toHash()] = $touchingCoordinate;
            }
        }
    }

    /**
     * Check if placing $tile at position is valid
     *
     * @param Tile       $tile       Tile to lay
     * @param Coordinate $coordinate Coordinate to check is valid
     *
     * @return bool
     */
    private function isValidPlacement(Tile $tile, Coordinate $coordinate)
    {
        //Check position being played on is occupied and playable
        if ($this->isOccupied($coordinate) || !$this->isPlayablePosition($coordinate)) {
            return false;
        }

        //Check the position being played is a valid move
        /** @var Coordinate $touchingCoordinate */
        foreach ($coordinate->getTouchingCoordinates() as $key => $touchingCoordinate) {
            // Continue if the touching coordinate is not occupied, go to next face
            if (!$this->isOccupied($touchingCoordinate)) {
                continue;
            }

            // Get the faces on the tile and touching tile to be matched
            if ($key == 'North') {
                $tileFace = $tile->getNorth();
                $matchingFace = $this->tiles[$touchingCoordinate->toHash()]->getSouth();
            } elseif ($key == 'East') {
                $tileFace = $tile->getEast();
                $matchingFace = $this->tiles[$touchingCoordinate->toHash()]->getWest();
            } elseif ($key == 'South') {
                $tileFace = $tile->getSouth();
                $matchingFace = $this->tiles[$touchingCoordinate->toHash()]->getNorth();
            } else { //West
                $tileFace = $tile->getWest();
                $matchingFace = $this->tiles[$touchingCoordinate->toHash()]->getEast();
            }

            //If these tile faces don't match, return false
            if ($tileFace != $matchingFace) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if a coordinate is in the playable positions array
     *
     * @param Coordinate $coordinate Position to check is occupied
     *
     * @returns bool
     */
    private function isPlayablePosition(Coordinate $coordinate)
    {
        return array_key_exists($coordinate->toHash(), $this->playablePositions);
    }

    /**
     * Draw current state of the map
     *
     * @param bool $finalRender Is this the final render
     * @param int  $delay       How long a delay should be given between rendering each move
     */
    public function render($finalRender = false, $delay = 0)
    {
        if (php_sapi_name() == "cli") {
            $this->renderCli($finalRender, $delay);
            return;
        }

        $this->renderWeb($finalRender);
    }

    /**
     * Render map to Web
     *
     * Will only render if finalRender is true
     *
     * @param bool $finalRender Is this the last render required for the game?
     */
    public function renderWeb($finalRender = false)
    {
        if (!$finalRender) {
            return;
        }

        echo '<style>body{overflow:scroll}</style><div style="white-space: nowrap;">';
        for ($y = $this->topRight->getY(); $y >= $this->bottomLeft->getY(); $y--) {
            for ($x = $this->bottomLeft->getX(); $x <= $this->topRight->getX(); $x++) {
                $currentCoordinate = new Coordinate($x, $y);

                echo "
                <!-- $x, $y -->
                ";
                if (!$this->isOccupied($currentCoordinate)) {
                    echo '<img src="/images/blank.png">';
                    continue;
                }

                $currentTile = $this->tiles[$currentCoordinate->toHash()];
                echo '<img
                src="/images/' . $currentTile->getImage() . '"
                style="transform: rotate(' . $currentTile->getRotation() . 'deg)">';
            }
            echo '<br>';
        }
    }

    /**
     * Render progressively to CLI
     *
     * @param bool $finalRender Is this the final render
     * @param int  $delay       How long a delay should be given between rendering each move
     */
    public function renderCli($finalRender, $delay = 0)
    {
        if ($finalRender) {
            echo 'Game Ended.' . PHP_EOL;
        }

        echo '    ';
        for ($x = $this->bottomLeft->getX(); $x <= $this->topRight->getX(); $x++) {
            echo str_pad((string) $x, 13, ' ', STR_PAD_BOTH);
        }
        echo PHP_EOL;

        for ($y = $this->topRight->getY(); $y >= $this->bottomLeft->getY(); $y--) {
            for ($renderTemp = 7; $renderTemp > 0; $renderTemp--) {
                if ($renderTemp == 4) {
                    echo str_pad((string) $y, 4, ' ', STR_PAD_RIGHT);
                } else {
                    echo '    ';
                }

                for ($x = $this->bottomLeft->getX(); $x <= $this->topRight->getX(); $x++) {
                    $currentCoordinate = new Coordinate($x, $y);

                    if (!$this->isOccupied($currentCoordinate)) {
                        echo "             ";
                        continue;
                    }

                    if (in_array($renderTemp, [1, 7])) {
                        echo " ----------- ";
                        continue;
                    }

                    $currentTile = $this->tiles[$currentCoordinate->toHash()];
                    switch ($renderTemp) {
                        case 6:
                            $north = $currentTile->getNorth();
                            echo " |    {$north}    | ";
                            break;
                        case 4:
                            $west = $currentTile->getWest();
                            $center = $currentTile->getCenter();
                            $east = $currentTile->getEast();
                            echo " |{$west}   {$center}   {$east}| ";
                            break;
                        case 2:
                            $south = $currentTile->getSouth();
                            echo " |    {$south}    | ";
                            break;
                        default:
                            echo " |         | ";
                    }
                }
                echo PHP_EOL;
            }
        }
        echo PHP_EOL;

        if (!$finalRender) {
            usleep($delay);
        }
    }
}
