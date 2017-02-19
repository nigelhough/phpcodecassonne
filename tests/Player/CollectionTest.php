<?php
declare(strict_types = 1);

namespace Codecassonne\Player;

/**
 * Test a Collection of Players
 */
class CollectionTest extends \PHPUnit_Framework_TestCase
{
    const PLAYER_INTERFACE = '\Codecassonne\Player\PlayerInterface';

    /**
     * Tests functionality of getPlayerCount
     */
    public function testGetPlayerCount()
    {
        $players = new Collection(
            $this->getMockBuilder(static::PLAYER_INTERFACE)->getMock()
        );
        $this->assertSame(1, $players->getPlayerCount());

        $players = new Collection(
            $this->getMockBuilder(static::PLAYER_INTERFACE)->getMock(),
            $this->getMockBuilder(static::PLAYER_INTERFACE)->getMock(),
            $this->getMockBuilder(static::PLAYER_INTERFACE)->getMock(),
            $this->getMockBuilder(static::PLAYER_INTERFACE)->getMock(),
            $this->getMockBuilder(static::PLAYER_INTERFACE)->getMock()
        );
        $this->assertSame(5, $players->getPlayerCount());
    }

    /**
     * Tests functionality of next method
     */
    public function testNext()
    {
        $first = $this->getMockBuilder(static::PLAYER_INTERFACE)->getMock();
        $second = $this->getMockBuilder(static::PLAYER_INTERFACE)->getMock();
        $third = $this->getMockBuilder(static::PLAYER_INTERFACE)->getMock();

        $players = new Collection($first, $second, $third);

        // In order
        $this->assertSame($first, $players->next());
        $this->assertSame($second, $players->next());
        $this->assertSame($third, $players->next());

        // Loops back
        $this->assertSame($first, $players->next());
    }
}
