<?php
declare(strict_types = 1);

namespace Codecassonne\Player;

use PHPUnit\Framework\TestCase;
use Codecassonne\Map\Coordinate;
use Codecassonne\Tile\Tile;
use Codecassonne\Map\Map;
use Codecassonne\Map\Exception\UnoccupiedCoordinate;
use Codecassonne\Turn\Action;

/**
 * Test All Players
 */
class PlayerTest extends TestCase
{
    /**
     * Get players to test
     *
     * @return array
     */
    public function getPlayers()
    {
        return [
            [
                'player' => new Marvin(),
                'name'   => 'Marvin, the Paranoid Android',
            ],
            [
                'player' => new Kryten(),
                'name'   => 'Kryten, Series 4000 Sanitation Droid',
            ],
        ];
    }

    /**
     * Test the get player name function
     *
     * @param PlayerInterface $player       The player to test getting the name of
     * @param string          $expectedName The expected player name
     *
     * @dataProvider getPlayers
     */
    public function testPlayerName(PlayerInterface $player, string $expectedName)
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
        $turnTests = [
            /**
             * Starting Tile and placing tile only have one city face so only one valid location and orientation
             *
             *          0
             *     -----------
             *     |    G    |
             *     |         |
             *1    |G   G   G|
             *     |         |
             *     |    C    |
             *     -----------
             *     -----------
             *     |    C    |
             *     |         |
             *0    |R   R   R|
             *     |         |
             *     |    R    |
             *     -----------
             *
             */
            [
                'startingTile'        => Tile::createFromString(Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_ROAD),
                'placingTile'         => Tile::createFromString(Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_GRASS),
                'expectedCoordinate'  => new Coordinate(0, 1),
                'expectedOrientation' => 0,
            ],
            /**
             * Starting Tile and placing tile only have one city face so only one valid location and orientation
             *
             *          0
             *     -----------
             *     |    G    |
             *     |         |
             *1    |G   G   G|
             *     |         |
             *     |    C    |
             *     -----------
             *     -----------
             *     |    C    |
             *     |         |
             *0    |R   R   R|
             *     |         |
             *     |    R    |
             *     -----------
             *
             */
            [
                'startingTile'        => Tile::createFromString(Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_ROAD),
                'placingTile'         => Tile::createFromString(Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_GRASS),
                'expectedCoordinate'  => new Coordinate(0, 1),
                'expectedOrientation' => 90,
            ],
            /**
             * Starting Tile and placing tile only have one city face so only one valid location and orientation
             * Different Starting Orientation
             *
             *          0
             *     -----------
             *     |    G    |
             *     |         |
             *1    |G   G   G|
             *     |         |
             *     |    C    |
             *     -----------
             *     -----------
             *     |    C    |
             *     |         |
             *0    |R   R   R|
             *     |         |
             *     |    R    |
             *     -----------
             *
             */
            [
                'startingTile'        => Tile::createFromString(Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_ROAD),
                'placingTile'         => Tile::createFromString(Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_GRASS),
                'expectedCoordinate'  => new Coordinate(0, 1),
                'expectedOrientation' => 180,
            ],
            /**
             * Starting Tile and placing tile only have one city face so only one valid location and orientation
             * Different Starting Orientation
             *
             *          0
             *     -----------
             *     |    G    |
             *     |         |
             *1    |G   G   G|
             *     |         |
             *     |    C    |
             *     -----------
             *     -----------
             *     |    C    |
             *     |         |
             *0    |R   R   R|
             *     |         |
             *     |    R    |
             *     -----------
             *
             */
            [
                'startingTile'        => Tile::createFromString(Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_ROAD),
                'placingTile'         => Tile::createFromString(Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_GRASS),
                'expectedCoordinate'  => new Coordinate(0, 1),
                'expectedOrientation' => 270,
            ],
            /**
             * Starting Tile and placing tile only have one city face so only one valid location and orientation
             *
             *          0
             *     -----------
             *     |    G    |
             *     |         |
             *1    |G   M   G|
             *     |         |
             *     |    R    |
             *     -----------
             *     -----------
             *     |    R    |
             *     |         |
             *0    |C   C   C|
             *     |         |
             *     |    C    |
             *     -----------
             *
             */
            [
                'startingTile'        => Tile::createFromString(Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_CITY),
                'placingTile'         => Tile::createFromString(Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_CLOISTER),
                'expectedCoordinate'  => new Coordinate(0, 1),
                'expectedOrientation' => 0,
            ],
            /**
             * Starting Tile and placing tile only have one city face so only one valid location and orientation
             *
             *          0
             *     -----------
             *     |    G    |
             *     |         |
             *1    |G   M   G|
             *     |         |
             *     |    R    |
             *     -----------
             *     -----------
             *     |    R    |
             *     |         |
             *0    |C   C   C|
             *     |         |
             *     |    C    |
             *     -----------
             *
             */
            [
                'startingTile'        => Tile::createFromString(Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_CITY),
                'placingTile'         => Tile::createFromString(Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_CLOISTER),
                'expectedCoordinate'  => new Coordinate(0, 1),
                'expectedOrientation' => 90,
            ],
            /**
             * Starting Tile and placing tile only have one city face so only one valid location and orientation
             * Different Starting Orientation
             *
             *          0
             *     -----------
             *     |    G    |
             *     |         |
             *1    |G   M   G|
             *     |         |
             *     |    R    |
             *     -----------
             *     -----------
             *     |    R    |
             *     |         |
             *0    |C   C   C|
             *     |         |
             *     |    C    |
             *     -----------
             *
             */
            [
                'startingTile'        => Tile::createFromString(Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_CITY),
                'placingTile'         => Tile::createFromString(Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_CLOISTER),
                'expectedCoordinate'  => new Coordinate(0, 1),
                'expectedOrientation' => 180,
            ],
            /**
             * Starting Tile and placing tile only have one city face so only one valid location and orientation
             * Different Starting Orientation
             *
             *          0
             *     -----------
             *     |    G    |
             *     |         |
             *1    |G   M   G|
             *     |         |
             *     |    R    |
             *     -----------
             *     -----------
             *     |    R    |
             *     |         |
             *0    |C   C   C|
             *     |         |
             *     |    C    |
             *     -----------
             *
             */
            [
                'startingTile'        => Tile::createFromString(Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_CITY),
                'placingTile'         => Tile::createFromString(Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_CLOISTER),
                'expectedCoordinate'  => new Coordinate(0, 1),
                'expectedOrientation' => 270,
            ],
            
        ];

        $turns = [];

        foreach ($this->getPlayers() as $player) {
            foreach ($turnTests as $test) {
                $turns[] = [
                    $player['player'],
                    new Map($test['startingTile']),
                    $test['placingTile'],
                    $test['expectedCoordinate'],
                    $test['expectedOrientation'],
                ];
            }
        }

        return $turns;
    }

    /**
     * Test a player making a turn
     * A Scenario is map and tile is passed to the Player that can only be played in a single coordinate and rotation
     *
     * @param PlayerInterface $player              The player to test playing a turn
     * @param Map             $map                 The map to play turn on
     * @param Tile            $tile                The tile to play
     * @param Coordinate      $expectedCoordinate  Specific coordinate expected in action
     * @param string          $expectedOrientation Specific tile orientation expected in action
     *
     * @dataProvider getTurns
     */
    public function testPlayTurn(
        PlayerInterface $player,
        Map $map,
        Tile $tile,
        $expectedCoordinate,
        $expectedOrientation
    ) {
        $action = $player->playTurn($map, $tile);

        $actionClass = new \ReflectionClass(Action::class);
        $coordinateProperty = $actionClass->getProperty('coordinate');
        $coordinateProperty->setAccessible(true);
        $rotationProperty = $actionClass->getProperty('rotation');
        $rotationProperty->setAccessible(true);

        $this->assertTrue($expectedCoordinate->isEqual($coordinateProperty->getValue($action)));
        $this->assertEquals($expectedOrientation, $rotationProperty->getValue($action));
    }

    /**
     * Data provider for invalid turn test
     *
     * @return array
     */
    public function getInvalidTurns()
    {
        $turnTests = [
            /**
             * No Valid Position to place Road Tile
             *
             *          0
             *     -----------
             *     |    C    |
             *     |         |
             *0    |C   C   C|
             *     |         |
             *     |    C    |
             *     -----------
             *
             *
             *     -----------
             *     |    R    |
             *     |         |
             *     |R   R   R|
             *     |         |
             *     |    R    |
             *     -----------
             */
            [
                'startingTile' => Tile::createFromString(Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_CITY),
                'placingTile'  => Tile::createFromString(Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_ROAD),
            ],
            /**
             * No Valid Position to place City Tile
             *
             *          0
             *     -----------
             *     |    R    |
             *     |         |
             *0    |R   R   R|
             *     |         |
             *     |    R    |
             *     -----------
             *
             *
             *     -----------
             *     |    C    |
             *     |         |
             *     |C   C   C|
             *     |         |
             *     |    C    |
             *     -----------
             */
            [
                'startingTile'  => Tile::createFromString(Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_ROAD),
                'placingTile' => Tile::createFromString(Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_CITY),
            ],
            /**
             * No Valid Position to place Cloister Tile only roads
             *
             *          0
             *     -----------
             *     |    R    |
             *     |         |
             *0    |R   R   R|
             *     |         |
             *     |    R    |
             *     -----------
             *
             *
             *     -----------
             *     |    G    |
             *     |         |
             *     |G   M   G|
             *     |         |
             *     |    G    |
             *     -----------
             */
            [
                'startingTile'  => Tile::createFromString(Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_ROAD),
                'placingTile' => Tile::createFromString(Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_CLOISTER),
            ],
            /**
             * No Valid Position to place Cloister Tile only city
             *
             *          0
             *     -----------
             *     |    C    |
             *     |         |
             *0    |C   C   C|
             *     |         |
             *     |    C    |
             *     -----------
             *
             *
             *     -----------
             *     |    G    |
             *     |         |
             *     |G   M   G|
             *     |         |
             *     |    G    |
             *     -----------
             */
            [
                'startingTile'  => Tile::createFromString(Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_CITY),
                'placingTile' => Tile::createFromString(Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_CLOISTER),
            ],
            /**
             * No Valid Position to place City Tile only Grass
             *
             *          0
             *     -----------
             *     |    G    |
             *     |         |
             *0    |G   M   G|
             *     |         |
             *     |    G    |
             *     -----------
             *
             *
             *     -----------
             *     |    C    |
             *     |         |
             *     |C   C   C|
             *     |         |
             *     |    C    |
             *     -----------
             */
            [
                'startingTile' => Tile::createFromString(Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_CLOISTER),
                'placingTile'  => Tile::createFromString(Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_CITY),
            ],
            /**
             * No Valid Position to place Road Tile only Grass
             *
             *          0
             *     -----------
             *     |    G    |
             *     |         |
             *0    |G   M   G|
             *     |         |
             *     |    G    |
             *     -----------
             *
             *
             *     -----------
             *     |    R    |
             *     |         |
             *     |R   R   R|
             *     |         |
             *     |    R    |
             *     -----------
             */
            [
                'startingTile' => Tile::createFromString(Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_GRASS . ':' . Tile::TILE_TYPE_CLOISTER),
                'placingTile'  => Tile::createFromString(Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_ROAD . ':' . Tile::TILE_TYPE_ROAD),
            ],
        ];

        $turns = [];

        foreach ($this->getPlayers() as $player) {
            foreach ($turnTests as $test) {
                $turns[] = [
                    $player['player'],
                    new Map($test['startingTile']),
                    $test['placingTile'],
                ];
            }
        }

        return $turns;
    }

    /**
     * Test a player making an invalid turn
     * All players should throw an Exception when there is no valid move
     *
     * @param PlayerInterface $player The player to test playing a turn
     * @param Map             $map    The map to play turn on
     * @param Tile            $tile   The tile to play
     *
     * @dataProvider getInvalidTurns
     * @expectedException \Codecassonne\Player\Exception\NoValidMove
     */
    public function testInvalidTurn(
        PlayerInterface $player,
        Map $map,
        Tile $tile
    ) {
        $player->playTurn($map, $tile);
    }

    /**
     * Data Provider to provide players for testing
     *
     * @return array
     */
    public function playerProvider()
    {
        $players = [];

        foreach ($this->getPlayers() as $player) {
            $players[] = [$player['player']];
        }

        return $players;
    }

    /**
     * Test a player making a turn on a Map with no playable positions
     * All players should throw an Exception when there is no playable positions
     *
     * @param PlayerInterface $player The player to test playing a turn
     *
     * @dataProvider playerProvider
     * @expectedException \Codecassonne\Player\Exception\NoPlayablePositions
     */
    public function testNoPlayablePositions(PlayerInterface $player)
    {
        // Create Dummy Feature Tile to add to City
        $map = $this
            ->getMockBuilder(Map::class)
            ->disableOriginalConstructor()
            ->getMock();
        $map->method('getPlayablePositions')
            ->willReturn([]);

        // Make sure no players are clever and try to work-out the playable positions themselves
        $map->method('isOccupied')
            ->willReturn(false);
        $map->method('look')
            ->willThrowException(new UnoccupiedCoordinate);

        $tile = Tile::createFromString(Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_CITY . ':' . Tile::TILE_TYPE_CITY);

        $player->playTurn($map, $tile);
    }
}
