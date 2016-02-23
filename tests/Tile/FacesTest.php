<?php

namespace Codecassonne\Tile;

/**
 * Test the Faces Class
 */
class FacesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Data Provide for Faces Tests
     */
    public function facesProvider()
    {
        return array(
            /** Matching Faces */
            array(
                array(
                    Tile::TILE_TYPE_ROAD,
                    Tile::TILE_TYPE_ROAD,
                    Tile::TILE_TYPE_ROAD,
                    Tile::TILE_TYPE_ROAD,
                    Tile::TILE_TYPE_GRASS,
                ),
                Tile::TILE_TYPE_ROAD.":".Tile::TILE_TYPE_ROAD.":".Tile::TILE_TYPE_ROAD.":".Tile::TILE_TYPE_ROAD.":".Tile::TILE_TYPE_GRASS,
            ),
            /** Mirrored Faces */
            array(
                array(
                    Tile::TILE_TYPE_ROAD,
                    Tile::TILE_TYPE_CITY,
                    Tile::TILE_TYPE_ROAD,
                    Tile::TILE_TYPE_CITY,
                    Tile::TILE_TYPE_GRASS,
                ),
                Tile::TILE_TYPE_ROAD.":".Tile::TILE_TYPE_CITY.":".Tile::TILE_TYPE_ROAD.":".Tile::TILE_TYPE_CITY.":".Tile::TILE_TYPE_GRASS,
            ),
            /** Matching Faces */
            array(
                array(
                    Tile::TILE_TYPE_GRASS,
                    Tile::TILE_TYPE_ROAD,
                    Tile::TILE_TYPE_CITY,
                    Tile::TILE_TYPE_GRASS,
                    Tile::TILE_TYPE_ROAD,
                ),
                Tile::TILE_TYPE_GRASS.":".Tile::TILE_TYPE_ROAD.":".Tile::TILE_TYPE_CITY.":".Tile::TILE_TYPE_GRASS.":".Tile::TILE_TYPE_ROAD,
            ),
        );
    }

    /**
     * Test the Faces toString function
     *
     * @param array $tileFaces          The Tile Faces
     * @param string $expectedString    The Expected Faces as a String
     *
     * @dataProvider facesProvider
     */
    public function testToString(array $tileFaces, $expectedString)
    {
        //Create Tile
        $faces = new Faces(
            $tileFaces[0],
            $tileFaces[1],
            $tileFaces[2],
            $tileFaces[3],
            $tileFaces[4]
        );

        //Assert the Faces object gives the expected string
        $this->assertSame($expectedString, $faces->toString());
    }

    /**
     * Test the Faces createFromString function
     *
     * @param array $expectedFaces   The Expected Tile Faces
     * @param string $facesString    Faces as a String
     *
     * @dataProvider facesProvider
     */
    public function testFromString(array $expectedFaces, $facesString)
    {
        //Create Faces from String
        $faces = Faces::createFromString($facesString);

        //Assert that the object toString function returns the string used to create the object
        $this->assertSame($faces->toString(), $facesString);
    }

    /**
     * Test getting readonly properties of Tile Faces
     *
     * @param array $tileFaces The Tile Faces
     *
     * @dataProvider facesProvider
     */
    public function testGetProperties(array $tileFaces)
    {
        //Create Faces
        $faces = new Faces(
            $tileFaces[0],
            $tileFaces[1],
            $tileFaces[2],
            $tileFaces[3],
            $tileFaces[4]
        );

        //Assert Accessing Read Only Properties
        $this->assertSame($faces->north, $tileFaces[0]);
        $this->assertSame($faces->east, $tileFaces[1]);
        $this->assertSame($faces->south, $tileFaces[2]);
        $this->assertSame($faces->west, $tileFaces[3]);
        $this->assertSame($faces->center, $tileFaces[4]);
    }

    /**
     * Test accessing an invalid property
     *
     * @expectedException InvalidArgumentException
     */
    public function testAccessingInvalidProperty()
    {
        //Create Faces
        $faces = new Faces(
            Tile::TILE_TYPE_ROAD,
            Tile::TILE_TYPE_ROAD,
            Tile::TILE_TYPE_ROAD,
            Tile::TILE_TYPE_ROAD,
            Tile::TILE_TYPE_GRASS
        );

        $faces->cheese;
    }

    /**
     * Test creating faces from Invalid String
     *
     * @expectedException InvalidArgumentException
     */
    public function testCreateFromInvalidString()
    {
        //Create Faces
        $faces = new Faces(
            Tile::TILE_TYPE_ROAD,
            Tile::TILE_TYPE_ROAD,
            Tile::TILE_TYPE_ROAD,
            Tile::TILE_TYPE_ROAD,
            Tile::TILE_TYPE_GRASS
        );

        $faces->createFromString('I Love Cheese');
    }
}
