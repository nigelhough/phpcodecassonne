<?php

namespace Codecassonne\Player;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    const PLAYER_INTERFACE = '\Codecassonne\Player\PlayerInterface';

    /**
     * Tests functionality of getPlayerCount
     */
    public function testGetPlayerCount()
    {
        $players = new Collection(
            $this->getMock(static::PLAYER_INTERFACE)
        );
        $this->assertSame(1, $players->getPlayerCount());

        $players = new Collection(
            $this->getMock(static::PLAYER_INTERFACE),
            $this->getMock(static::PLAYER_INTERFACE),
            $this->getMock(static::PLAYER_INTERFACE),
            $this->getMock(static::PLAYER_INTERFACE),
            $this->getMock(static::PLAYER_INTERFACE)
        );
        $this->assertSame(5, $players->getPlayerCount());
    }

    /**
     * Tests functionality of next method
     */
    public function testNext()
    {
        $first = $this->getMock(static::PLAYER_INTERFACE);
        $second = $this->getMock(static::PLAYER_INTERFACE);
        $third = $this->getMock(static::PLAYER_INTERFACE);

        $players = new Collection($first, $second, $third);

        // In order
        $this->assertSame($first, $players->next());
        $this->assertSame($second, $players->next());
        $this->assertSame($third, $players->next());

        // Loops back
        $this->assertSame($first, $players->next());
    }
}
