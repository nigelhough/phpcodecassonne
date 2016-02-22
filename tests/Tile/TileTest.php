<?php

namespace Codecassonne\Tile;

//Autoload application
require __DIR__ . '/../../vendor/autoload.php';

/**
 * Test the Tile Class
 */
class TileTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Data Provide for Rotate Function
     */
    public function rotateProvider()
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
                array(
                    Tile::TILE_TYPE_ROAD,
                    Tile::TILE_TYPE_ROAD,
                    Tile::TILE_TYPE_ROAD,
                    Tile::TILE_TYPE_ROAD,
                    Tile::TILE_TYPE_GRASS,
                ),
            ),
            /** Matching Faces, Different Center */
            array(
                array(
                    Tile::TILE_TYPE_ROAD,
                    Tile::TILE_TYPE_ROAD,
                    Tile::TILE_TYPE_ROAD,
                    Tile::TILE_TYPE_ROAD,
                    Tile::TILE_TYPE_ROAD,
                ),
                array(
                    Tile::TILE_TYPE_ROAD,
                    Tile::TILE_TYPE_ROAD,
                    Tile::TILE_TYPE_ROAD,
                    Tile::TILE_TYPE_ROAD,
                    Tile::TILE_TYPE_ROAD,
                ),
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
                array(
                    Tile::TILE_TYPE_CITY,
                    Tile::TILE_TYPE_ROAD,
                    Tile::TILE_TYPE_CITY,
                    Tile::TILE_TYPE_ROAD,
                    Tile::TILE_TYPE_GRASS,
                ),
            ),
            /** A sequential sequence */
            array(
                array(
                    Tile::TILE_TYPE_GRASS,
                    Tile::TILE_TYPE_ROAD,
                    Tile::TILE_TYPE_CITY,
                    Tile::TILE_TYPE_GRASS,
                    Tile::TILE_TYPE_GRASS,
                ),
                array(
                    Tile::TILE_TYPE_GRASS,
                    Tile::TILE_TYPE_GRASS,
                    Tile::TILE_TYPE_ROAD,
                    Tile::TILE_TYPE_CITY,
                    Tile::TILE_TYPE_GRASS,
                ),
            ),
            /** A sequential sequence continued */
            array(
                array(
                    Tile::TILE_TYPE_GRASS,
                    Tile::TILE_TYPE_GRASS,
                    Tile::TILE_TYPE_ROAD,
                    Tile::TILE_TYPE_CITY,
                    Tile::TILE_TYPE_GRASS,
                ),
                array(
                    Tile::TILE_TYPE_CITY,
                    Tile::TILE_TYPE_GRASS,
                    Tile::TILE_TYPE_GRASS,
                    Tile::TILE_TYPE_ROAD,
                    Tile::TILE_TYPE_GRASS,
                ),
            ),
        );
    }

    /**
     * Test the Tile Rotate function
     *
     * @param array $tileFaces     The Initial Tile Layout
     * @param array $rotatedFaces  The Expected Rotated Layout
     *
     * @dataProvider rotateProvider
     */
    public function testRotate(array $tileFaces, array $rotatedFaces)
    {
        //Create Tile
        $tile = new Tile(
            $tileFaces[0],
            $tileFaces[1],
            $tileFaces[2],
            $tileFaces[3],
            $tileFaces[4]
        );

        //Assert Tile Layout is loaded correctly
        $this->assertSame($tileFaces, $tile->getTileFaces());

        //Rotate Tile
        $tile->rotate();

        //Assert Rotated Tile Layout is Expected
        $this->assertSame($rotatedFaces, $tile->getTileFaces());
    }

}