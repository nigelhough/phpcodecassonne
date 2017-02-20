<?php

namespace Codecassonne\Map;

class CoordinateTest extends \PHPUnit\Framework\TestCase
{
    /**
     *
     */
    public function constructorProvider()
    {
        return array(
            /** Valid Coordinates */
            array(
                10,
                06,
                '',
            ),
            /** Invalid X Coordinate */
            array(
                'Cheese',
                06,
                'TypeError',
            ),
            /** Invalid X and Y Coordinate. X Fails first */
            array(
                'Cheese',
                'Sticks',
                'TypeError',
            ),
            /** Invalid Y Coordinate */
            array(
                10,
                'Cheese',
                'TypeError',
            ),
            /** Random Y Coordinate */
            array(
                10,
                new \Exception(),
                'TypeError',
            ),
        );
    }

    /**
     * Test Creating Coordinate Objects
     *
     * @param int $xCoordinate X Coordinate
     * @param int $yCoordinate Y Coordinate
     * @param string $expectedException Exception Exception
     *
     * @dataProvider constructorProvider
     */
    public function testConstructor(
        $xCoordinate,
        $yCoordinate,
        $expectedException
    ) {
        if ($expectedException) {
            $this->expectException($expectedException);
        }

        new Coordinate($xCoordinate, $yCoordinate);
    }

    /**
     * Provider for Coordinate tests
     */
    public function coordinateProvider()
    {
        return array(
            /** Starting Coordinate */
            array(
                new Coordinate(0, 0),
                '0,0',
                'fc3ce29e4cbee5e7185f3b528b4dd1bc',
                0,
                0,
            ),
            /** North Coordinate */
            array(
                new Coordinate(0, 1),
                '0,1',
                'd192e0c4ad64a9c35fe32972477e4cd8',
                0,
                1,
            ),
            /** North East Coordinate */
            array(
                new Coordinate(1, 1),
                '1,1',
                '157bbeed38aee8e24cb9b44422606e74',
                1,
                1,
            ),
            /** East Coordinate */
            array(
                new Coordinate(1, 0),
                '1,0',
                'd41449530804491d9c79e88457e9b3c2',
                1,
                0,
            ),
            /** South East Coordinate */
            array(
                new Coordinate(1, -1),
                '1,-1',
                '165a5ce99ceacc38cb89efe303bc7832',
                1,
                -1,
            ),
            /** South Coordinate */
            array(
                new Coordinate(0, -1),
                '0,-1',
                'cdc0a8f9fe7f5e206d167723a90af880',
                0,
                -1,
            ),
            /** South West Coordinate */
            array(
                new Coordinate(-1, -1),
                '-1,-1',
                'b8eb29fbdbf44195684418865e4d6555',
                -1,
                -1,
            ),
            /** West Coordinate */
            array(
                new Coordinate(-1, 0),
                '-1,0',
                'e0dd3899ddcb265c2ad89cdbed91ff6d',
                -1,
                0,
            ),
            /** North Coordinate */
            array(
                new Coordinate(-1, 1),
                '-1,1',
                'f47d786139430de44cc0c08ec384575e',
                -1,
                1,
            ),
            /** Random Coordinate */
            array(
                new Coordinate(10, 06),
                '10,6',
                '623bc0290d647f7dcf95fcf4e5fed318',
                10,
                6,
            ),
        );
    }

    /**
     * Test the To String function
     *
     * @param Coordinate $testCoordinate Coordinate to test
     * @param string $expectedString Expected string response
     * @param string $expectedHash Expected hash response
     * @param int $expectedX Expected X Coordinate
     * @param int $expectedY Expected Y Coordinate
     *
     * @dataProvider    coordinateProvider
     */
    public function testToString(
        Coordinate $testCoordinate,
        $expectedString,
        $expectedHash,
        $expectedX,
        $expectedY
    )
    {
        /** Test To String Function */
        $this->assertSame($expectedString, $testCoordinate->toString());

        /** Test To Hash Function */
        $this->assertSame($expectedHash, $testCoordinate->toHash());

        /** Test Get X Function */
        $this->assertSame($expectedX, $testCoordinate->getX());

        /** Test Get Y Function */
        $this->assertSame($expectedY, $testCoordinate->getY());
    }

    /**
     * Provider for Coordinate Is Equal Test
     */
    public function coordinateISEqualProvider()
    {
        return array(
            /** Two matching Coordinates */
            array(
                new Coordinate(0, 0),
                new Coordinate(0, 0),
                true
            ),
            /** Two non-matching Coordinates */
            array(
                new Coordinate(0, 0),
                new Coordinate(0, 1),
                false
            ),
            /** Two non-matching negative Coordinates */
            array(
                new Coordinate(0, 0),
                new Coordinate(0, -1),
                false
            ),
            /** Two non-matching inverse Coordinates */
            array(
                new Coordinate(1, 1),
                new Coordinate(-1, -1),
                false
            ),
            /** Two non-matching offset Coordinates */
            array(
                new Coordinate(1, 0),
                new Coordinate(0, 1),
                false
            )
        );
    }

    /**
     * Test Coordinate Is Equal function
     *
     * @param Coordinate $testCoordinate1 First Test Coordinate
     * @param Coordinate $testCoordinate2 First Test Coordinate
     * @param bool $coordinatesMatch Do the Coordinates Match
     *
     * @dataProvider coordinateISEqualProvider
     */
    public function testIsEqual(
        Coordinate $testCoordinate1,
        Coordinate $testCoordinate2,
        $coordinatesMatch
    )
    {

        /** Test Coordinate 1 is equal to itself */
        $this->assertTrue($testCoordinate1->isEqual($testCoordinate1));

        /** Test Coordinate 2 is equal to itself */
        $this->assertTrue($testCoordinate2->isEqual($testCoordinate2));

        if ($coordinatesMatch) {
            /** Test Coordinate 1 is equal to Coordinate2 */
            $this->assertTrue($testCoordinate1->isEqual($testCoordinate2));
        } else {
            /** Test Coordinate 1 is NOT equal to Coordinate 2 */
            $this->assertFalse($testCoordinate1->isEqual($testCoordinate2));
        }
    }

    /**
     * Data provider for the get touching parameters function
     *
     * @return array
     */
    public function touchingProvider()
    {
        return array(
            array(
                new Coordinate(0, 0),
                array(
                    'North' => new Coordinate(0, 1),
                    'East' => new Coordinate(1, 0),
                    'South' => new Coordinate(0, -1),
                    'West' => new Coordinate(-1, 0),
                ),
            ),
            array(
                new Coordinate(10, 10),
                array(
                    'North' => new Coordinate(10, 11),
                    'East' => new Coordinate(11, 10),
                    'South' => new Coordinate(10, 9),
                    'West' => new Coordinate(9, 10),
                ),
            ),
            array(
                new Coordinate(-10, -10),
                array(
                    'North' => new Coordinate(-10, -9),
                    'East' => new Coordinate(-9, -10),
                    'South' => new Coordinate(-10, -11),
                    'West' => new Coordinate(-11, -10),
                ),
            ),
        );
    }

    /**
     * Test the get Touching Coordinates function
     *
     * @param Coordinate    $coordinate
     * @param Coordinate[]  $expectedCoordinates
     *
     * @dataProvider touchingProvider
     */
    public function testGetTouching(Coordinate $coordinate, array $expectedCoordinates)
    {
        //Get touching coordinates
        $touchingCoordinates = $coordinate->getTouchingCoordinates();

        //Test all of the coordinates match expected
        foreach($expectedCoordinates as $key => $expectedCoordinate) {
            $this->assertTrue(
                $expectedCoordinate->isEqual($touchingCoordinates[$key])
            );
        }
    }
}
