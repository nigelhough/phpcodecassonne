<?php

namespace Codecassonne\Player;

use Codecassonne\Map\Coordinate;
use Codecassonne\Tile\Tile;
use Codecassonne\Map\Map;

class PlayerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Get players to test
     *
     * @return array
     */
    public function getPlayers()
    {
        return array(
            array(
                'player'    => new Marvin(),
                'name'      => 'Marvin, the Paranoid Android'
            ),
        );
    }

    /**
     * Test the get player name function
     *
     * @param PlayerInterface   $player   The player to test getting the name of
     *
     * @dataProvider getPlayers
     */
    public function testPlayerName(PlayerInterface $player, $expectedName)
    {
        $this->assertSame($expectedName, $player->getName());
    }

    /**
     * Data provider for player test
     *
     * @return array
     */
    public function getTurns()
    {
        $players = $this->getPlayers();

        $turnTests = array(
            /** Starting Tile and Placing tile only has one valid position and orientation */
            array(
                'startingTile' => Tile::createFromString(Tile::TILE_TYPE_CITY.':'.Tile::TILE_TYPE_ROAD.':'.Tile::TILE_TYPE_ROAD.':'.Tile::TILE_TYPE_ROAD.':'.Tile::TILE_TYPE_ROAD),
                'placingTile' => Tile::createFromString(Tile::TILE_TYPE_GRASS.':'.Tile::TILE_TYPE_CITY.':'.Tile::TILE_TYPE_GRASS.':'.Tile::TILE_TYPE_GRASS.':'.Tile::TILE_TYPE_GRASS),
                'expectedException' => false,
                'expectedCoordinate' => new Coordinate(0, 1),
                'expectedOrientation' => 90,
            ),
            /** Same valid position and orientation, different starting orientaion */
            array(
                'startingTile' => Tile::createFromString(Tile::TILE_TYPE_CITY.':'.Tile::TILE_TYPE_ROAD.':'.Tile::TILE_TYPE_ROAD.':'.Tile::TILE_TYPE_ROAD.':'.Tile::TILE_TYPE_ROAD),
                'placingTile' => Tile::createFromString(Tile::TILE_TYPE_CITY.':'.Tile::TILE_TYPE_GRASS.':'.Tile::TILE_TYPE_GRASS.':'.Tile::TILE_TYPE_GRASS.':'.Tile::TILE_TYPE_GRASS),
                'expectedException' => false,
                'expectedCoordinate' => new Coordinate(0, 1),
                'expectedOrientation' => 180,
            ),
            /** Same valid position and orientation, different starting orientaion */
            array(
                'startingTile' => Tile::createFromString(Tile::TILE_TYPE_CITY.':'.Tile::TILE_TYPE_ROAD.':'.Tile::TILE_TYPE_ROAD.':'.Tile::TILE_TYPE_ROAD.':'.Tile::TILE_TYPE_ROAD),
                'placingTile' => Tile::createFromString(Tile::TILE_TYPE_GRASS.':'.Tile::TILE_TYPE_GRASS.':'.Tile::TILE_TYPE_GRASS.':'.Tile::TILE_TYPE_CITY.':'.Tile::TILE_TYPE_GRASS),
                'expectedException' => false,
                'expectedCoordinate' => new Coordinate(0, 1),
                'expectedOrientation' => 270,
            ),
            /** Same valid position and orientation, different starting orientaion */
            array(
                'startingTile' => Tile::createFromString(Tile::TILE_TYPE_CITY.':'.Tile::TILE_TYPE_CITY.':'.Tile::TILE_TYPE_CITY.':'.Tile::TILE_TYPE_CITY.':'.Tile::TILE_TYPE_CITY),
                'placingTile' => Tile::createFromString(Tile::TILE_TYPE_ROAD.':'.Tile::TILE_TYPE_ROAD.':'.Tile::TILE_TYPE_ROAD.':'.Tile::TILE_TYPE_ROAD.':'.Tile::TILE_TYPE_ROAD),
                'expectedException' => true,
                'expectedCoordinate' => null,
                'expectedOrientation' => null,
            ),
        );

        $turns = array();

        foreach ($players as $player) {
            foreach ($turnTests as $test) {
                $turns[] = array(
                    $player['player'],
                    new Map($test['startingTile']),
                    $test['placingTile'],
                    $test['expectedException'],
                    $test['expectedCoordinate'],
                    $test['expectedOrientation'],
                );
            }
        }

        return $turns;
    }

    /**
     * Test a player making a turn
     *
     * @param PlayerInterface   $player                 The player to test playing a turn
     * @param Map               $map                    The map to play turn on
     * @param Tile              $tile                   The tile to play
     * @param bool              $expectedException      Is an Exception expected
     * @param Coordinate        $expectedCoordinate     Specific coordinate expected in action
     * @param string            $expectedOrientation    Specific tile orientation expected in action
     *
     * @dataProvider getTurns
     */
    public function testPlayTurn(
        PlayerInterface $player,
        Map $map,
        Tile $tile,
        bool $expectedException,
        $expectedCoordinate,
        $expectedOrientation
    ) {
        if ($expectedException) {
           $this->setExpectedException('Exception');
        }
        $action = $player->playTurn($map, $tile);

        $this->assertTrue($expectedCoordinate->isEqual($action->getCoordinate()));
        $this->assertEquals($expectedOrientation, $action->getRotation());
    }
}
