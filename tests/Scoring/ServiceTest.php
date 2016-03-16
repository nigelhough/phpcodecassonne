<?php

namespace Codecassonne\Scoring;

use Codecassonne\Map\Map;
use Codecassonne\Map\Coordinate;
use Codecassonne\Tile\Tile;

class ServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function scoringProvider()
    {
        return array(
            /** Create Basic Two Tile City Map  */
            array(
                $this->createMap(
                    array(
                        (new Coordinate(0,0))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                        (new Coordinate(0,1))->toHash() =>
                            Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                    )
                ),
                new Coordinate(0,1),
                4
            ),
        );
    }

    /**
     * Creates a map from an array of tiles
     *
     * @param array $tiles  Array of tiles to set the state of the map
     *
     * @return Map
     */
    private function createMap(array $tiles)
    {
        //Dummy Tile
        $tile = Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS);

        // Create Map
        $map = new Map($tile);

        // Make Map properties accessible
        $mapReflection = new \ReflectionClass('Codecassonne\Map\Map');
        $tilesReflection = $mapReflection->getProperty('tiles');
        $tilesReflection->setAccessible(true);

        // Set the Bag Tiles
        $tilesReflection->setValue($map, $tiles);

        return $map;
    }

    /**
     * Test the scoring service
     *
     * @param Map           $map                Map to score
     * @param Coordinate    $placedCoordinate   Coordinate to score
     * @param int           $expectedScore      Expected Score
     *
     * @dataProvider scoringProvider
     */
    public function testScoring(Map $map,Coordinate $placedCoordinate, int $expectedScore)
    {
        //Test calculating the score
        $score = Service::calculateScore($map, $placedCoordinate);

        //Check the score is as expected
        $this->assertEquals($expectedScore, $score);
    }
}
