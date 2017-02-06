<?php
declare(strict_types=1);

namespace Codecassonne\Tile;

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
        $this->assertSame(implode(':', $tileFaces), $tile->toString());

        //Rotate Tile
        $tile->rotate();

        //Assert Rotated Tile Layout is Expected
        $this->assertSame(implode(':', $rotatedFaces), $tile->toString());
    }

    /**
     * Range of valid data for rotateTo
     *
     * @return array
     */
    public function rotateToProvider()
    {
        return [
            [-450, 270],
            [-360, 0],
            [-270, 90],
            [-180, 180],
            [-90, 270],
            [0, 0],
            [90, 90],
            [180, 180],
            [270, 270],
            [360, 0],
            [450, 90]
        ];
    }

    /**
     * @param $rotation
     * @param $expected
     *
     * @dataProvider rotateToProvider
     */
    public function testRotateTo($rotation, $expected)
    {
        $tile = Tile::createFromString('G:C:R:C:C');

        $tile->rotateTo($rotation);

        $this->assertSame($expected, $tile->getRotation());
    }

    /**
     * Provide invalid input for rotateTo test
     */
    public function invalidRotateProvider()
    {
        return [
            [1],
            [-57]
        ];
    }

    /**
     * @param $input
     *
     * @dataProvider invalidRotateProvider
     * @expectedException \InvalidArgumentException
     */
    public function testRotateToInvalid($input)
    {
        $tile = Tile::createFromString('G:C:R:C:C');
        $tile->rotateTo($input);
    }

    /**
     * Data Provider for Create From Invalid String Test
     * @return array
     */
    public function invalidCreateFromStringProvider()
    {
        return array(
            /** Invalid String */
            array(
                'I Like Cheese',
            ),
            /** String with not enough attributes */
            array(
                Tile::TILE_TYPE_ROAD.":".Tile::TILE_TYPE_ROAD.":".Tile::TILE_TYPE_ROAD.":".Tile::TILE_TYPE_ROAD,
            ),
            /** String with too many attributes*/
            array(
                Tile::TILE_TYPE_ROAD.":".Tile::TILE_TYPE_ROAD.":".Tile::TILE_TYPE_ROAD.":".Tile::TILE_TYPE_ROAD.":".Tile::TILE_TYPE_ROAD.":".Tile::TILE_TYPE_ROAD,
            ),
            /** Invalid with invalid seperators */
            array(
                Tile::TILE_TYPE_ROAD.";".Tile::TILE_TYPE_ROAD.";".Tile::TILE_TYPE_ROAD.";".Tile::TILE_TYPE_ROAD.";".Tile::TILE_TYPE_GRASS,
            ),
            /** String with Invalid characters appended to constants */
            array(
                Tile::TILE_TYPE_ROAD."A:".Tile::TILE_TYPE_ROAD."B:".Tile::TILE_TYPE_ROAD."C:".Tile::TILE_TYPE_ROAD."D:".Tile::TILE_TYPE_GRASS,
            ),
            /** Invalid positioning for cloister */
            array(
                Tile::TILE_TYPE_CLOISTER.":".Tile::TILE_TYPE_GRASS.":".Tile::TILE_TYPE_GRASS.":".Tile::TILE_TYPE_GRASS.":".Tile::TILE_TYPE_GRASS,
            )
        );
    }

    /**
     * Test creating Tile from Invalid String
     *
     * @param string $tileString    Tile as a String
     *
     * @dataProvider invalidCreateFromStringProvider
     * @expectedException \InvalidArgumentException
     */
    public function testCreateFromInvalidString($tileString)
    {
        Tile::createFromString($tileString);
    }

    /**
     * Data Provide for Tile String Tests
     */
    public function tileStringProvider()
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
            /** Cloister */
            array(
                array(
                    Tile::TILE_TYPE_GRASS,
                    Tile::TILE_TYPE_GRASS,
                    Tile::TILE_TYPE_GRASS,
                    Tile::TILE_TYPE_GRASS,
                    Tile::TILE_TYPE_CLOISTER,
                ),
                Tile::TILE_TYPE_GRASS.":".Tile::TILE_TYPE_GRASS.":".Tile::TILE_TYPE_GRASS.":".Tile::TILE_TYPE_GRASS.":".Tile::TILE_TYPE_CLOISTER,
            ),
        );
    }

    /**
     * Test the Tile toString function
     *
     * @param array $tileFaces          The Tile Faces
     * @param string $expectedString    The Expected Faces as a String
     *
     * @dataProvider tileStringProvider
     */
    public function testToString(array $tileFaces, $expectedString)
    {
        //Create Tile
        $tile = new Tile(
            $tileFaces[0],
            $tileFaces[1],
            $tileFaces[2],
            $tileFaces[3],
            $tileFaces[4]
        );

        //Assert the Faces object gives the expected string
        $this->assertSame($expectedString, $tile->toString());
    }

    /**
     * Test the Tile createFromString function
     *
     * @param array $expectedFaces   The Expected Tile Faces
     * @param string $facesString    Faces as a String
     *
     * @dataProvider tileStringProvider
     */
    public function testFromString(array $expectedFaces, $facesString)
    {
        //Create Tile from String
        $tile = Tile::createFromString($facesString);

        //Assert that the toString function returns the string used to create the object
        $this->assertSame($tile->toString(), $facesString);
    }

    /**
     * Data Provider for Get Features Test
     *
     * @return array
     */
    public function getFeaturesProvider()
    {
        return [
            /** INDIVIDUAL CITIES */
            /** City North of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                [
                    ['North'],
                ]
            ],
            /** City East of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                [
                    ['East'],
                ]
            ],
            /** City South of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                [
                    ['South'],
                ]
            ],
            /** City West of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                [
                    ['West'],
                ]
            ],
            /** Cities North and East of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                [
                    ['North'],
                    ['East'],
                ]
            ],
            /** Cities North and South of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                [
                    ['North'],
                    ['South'],
                ]
            ],
            /** Cities North and West of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                [
                    ['North'],
                    ['West'],
                ]
            ],
            /** Cities East and South of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                [
                    ['East'],
                    ['South'],
                ]
            ],
            /** Cities East and West of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                [
                    ['East'],
                    ['West'],
                ]
            ],
            /** Cities South and West of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                [
                    ['South'],
                    ['West'],
                ]
            ],
            /** Cities North, East and South of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                [
                    ['North'],
                    ['East'],
                    ['South'],
                ]
            ],
            /** Cities North, East and West of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                [
                    ['North'],
                    ['East'],
                    ['West'],
                ]
            ],
            /** Cities North, South and West of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                [
                    ['North'],
                    ['South'],
                    ['West'],
                ]
            ],
            /** Cities East, South and West of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                [
                    ['East'],
                    ['South'],
                    ['West'],
                ]
            ],
            /** Cities North, East, South and West of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS),
                [
                    ['North'],
                    ['East'],
                    ['South'],
                    ['West'],
                ]
            ],

            /** INDIVIDUAL ROADS */
            /** Road North of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                ]
            ],
            /** Road East of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['East'],
                ]
            ],
            /** Road South of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['South'],
                ]
            ],
            /** Road West of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['West'],
                ]
            ],
            /** Roads North and East of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['East'],
                ]
            ],
            /** Roads North and South of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['South'],
                ]
            ],
            /** Roads North and West of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['West'],
                ]
            ],
            /** Roads East and South of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['East'],
                    ['South'],
                ]
            ],
            /** Roads East and West of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['East'],
                    ['West'],
                ]
            ],
            /** Roads South and West of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['South'],
                    ['West'],
                ]
            ],
            /** Roads North, East and South of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['East'],
                    ['South'],
                ]
            ],
            /** Roads North, East and West of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['East'],
                    ['West'],
                ]
            ],
            /** Roads North, South and West of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['South'],
                    ['West'],
                ]
            ],
            /** Roads East, South and West of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['East'],
                    ['South'],
                    ['West'],
                ]
            ],
            /** Roads North, East, South and West of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['East'],
                    ['South'],
                    ['West'],
                ]
            ],

            /** INDIVIDUAL ROADS AND CITIES */
            /** City North of Tile, Road East */
            [
                Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['East'],
                ]
            ],
            /** City North of Tile, Road South */
            [
                Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['South'],
                ]
            ],
            /** City North of Tile, Road West */
            [
                Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['West'],
                ]
            ],
            /** City East of Tile, Road South */
            [
                Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['East'],
                    ['South'],
                ]
            ],
            /** City East of Tile, Road West */
            [
                Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['East'],
                    ['West'],
                ]
            ],
            /** City East of Tile, Road North */
            [
                Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['East'],
                ]
            ],
            /** City South of Tile, Road West */
            [
                Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['South'],
                    ['West'],
                ]
            ],
            /** City South of Tile, Road North */
            [
                Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['South'],
                ]
            ],
            /** City South of Tile, Road East */
            [
                Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['East'],
                    ['South'],
                ]
            ],
            /** City West of Tile, Road North */
            [
                Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['West'],
                ]
            ],
            /** City West of Tile, Road East */
            [
                Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['East'],
                    ['West'],
                ]
            ],
            /** City West of Tile, Road South */
            [
                Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['South'],
                    ['West'],
                ]
            ],
            /** City North, East of Tile, Road South */
            [
                Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['East'],
                    ['South'],
                ]
            ],
            /** City North, East of Tile, Road West */
            [
                Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['East'],
                    ['West'],
                ]
            ],
            /** City East, South of Tile, Road West */
            [
                Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['East'],
                    ['South'],
                    ['West'],
                ]
            ],
            /** City East, South of Tile, Road North */
            [
                Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['East'],
                    ['South'],
                ]
            ],
            /** City South, West of Tile, Road North */
            [
                Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['South'],
                    ['West'],
                ]
            ],
            /** City South, West of Tile, Road East */
            [
                Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['East'],
                    ['South'],
                    ['West'],
                ]
            ],
            /** City West, North of Tile, Road East */
            [
                Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['East'],
                    ['West'],
                ]
            ],
            /** City West, North of Tile, Road South */
            [
                Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['South'],
                    ['West'],
                ]
            ],
            /** Road North, East of Tile, City South */
            [
                Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['East'],
                    ['South'],
                ]
            ],
            /** Road North, East of Tile, City West */
            [
                Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['East'],
                    ['West'],
                ]
            ],
            /** Road East, South of Tile, City West */
            [
                Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['East'],
                    ['South'],
                    ['West'],
                ]
            ],
            /** Road East, South of Tile, City North */
            [
                Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['East'],
                    ['South'],
                ]
            ],
            /** Road South, West of Tile, City North */
            [
                Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['South'],
                    ['West'],
                ]
            ],
            /** Road South, West of Tile, City East */
            [
                Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['East'],
                    ['South'],
                    ['West'],
                ]
            ],
            /** Road West, North of Tile, City East */
            [
                Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['East'],
                    ['West'],
                ]
            ],
            /** Road West, North of Tile, City South */
            [
                Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['South'],
                    ['West'],

                ]
            ],

            /** City North, East of Tile, Road South, West */
            [
                Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['East'],
                    ['South'],
                    ['West'],
                ]
            ],
            /** City East, South of Tile, Road North, West */
            [
                Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['East'],
                    ['South'],
                    ['West'],
                ]
            ],
            /** City South, West of Tile, Road North, East */
            [
                Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['East'],
                    ['South'],
                    ['West'],
                ]
            ],
            /** City North, West of Tile, Road East, South */
            [
                Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['East'],
                    ['South'],
                    ['West'],
                ]
            ],
            /** City North, South of Tile, Road East West */
            [
                Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['East'],
                    ['South'],
                    ['West'],
                ]
            ],
            /** Road North, South of Tile, City East West */
            [
                Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['East'],
                    ['South'],
                    ['West'],
                ]
            ],
            /** City North, East, South of Tile, Road West */
            [
                Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['East'],
                    ['South'],
                    ['West'],
                ]
            ],
            /** City North, East, West of Tile, South West */
            [
                Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['East'],
                    ['South'],
                    ['West'],
                ]
            ],
            /** City North, South, West of Tile, Road South */
            [
                Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['East'],
                    ['South'],
                    ['West'],
                ]
            ],
            /** City East, South, West of Tile, Road North */
            [
                Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['East'],
                    ['South'],
                    ['West'],
                ]
            ],
            /** Road North, East, South of Tile, City West */
            [
                Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['East'],
                    ['South'],
                    ['West'],
                ]
            ],
            /** Road North, East, West of Tile, South West */
            [
                Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['East'],
                    ['South'],
                    ['West'],
                ]
            ],
            /** Road North, South, West of Tile, City South */
            [
                Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['East'],
                    ['South'],
                    ['West'],
                ]
            ],
            /** Road East, South, West of Tile, City North */
            [
                Tile::createFromString(Tile::TILE_TYPE_CITY . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_CLOISTER),
                [
                    ['North'],
                    ['East'],
                    ['South'],
                    ['West'],
                ]
            ],
        ];
    }

    /**
     * Test getting the features on a tile
     *
     * @param Tile  $tile               Tile to get features on
     * @param array $expectedFeatures   Expected Features to be returned
     *
     * @todo improve assertion to be independent of array order
     *
     * @dataProvider getFeaturesProvider
     */
    public function testGetFeatures(Tile $tile, array $expectedFeatures)
    {
        $features = $tile->getFeatures();

        //$this->assertCount(count($expectedFeatures), $features);
        $this->assertSame($expectedFeatures, $features);
    }
}
