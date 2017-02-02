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
                Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                [
                    ['North'],
                ]
            ],
            /** Road East of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                [
                    ['East'],
                ]
            ],
            /** Road South of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                [
                    ['South'],
                ]
            ],
            /** Road West of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS),
                [
                    ['West'],
                ]
            ],
            /** Roads North and East of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                [
                    ['North'],
                    ['East'],
                ]
            ],
            /** Roads North and South of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                [
                    ['North'],
                    ['South'],
                ]
            ],
            /** Roads North and West of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS),
                [
                    ['North'],
                    ['West'],
                ]
            ],
            /** Roads East and South of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                [
                    ['East'],
                    ['South'],
                ]
            ],
            /** Roads East and West of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS),
                [
                    ['East'],
                    ['West'],
                ]
            ],
            /** Roads South and West of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS),
                [
                    ['South'],
                    ['West'],
                ]
            ],
            /** Roads North, East and South of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_GRASS),
                [
                    ['North'],
                    ['East'],
                    ['South'],
                ]
            ],
            /** Roads North, East and West of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS),
                [
                    ['North'],
                    ['East'],
                    ['West'],
                ]
            ],
            /** Roads North, South and West of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS),
                [
                    ['North'],
                    ['South'],
                    ['West'],
                ]
            ],
            /** Roads East, South and West of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_GRASS . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS),
                [
                    ['East'],
                    ['South'],
                    ['West'],
                ]
            ],
            /** Roads North, East, South and West of Tile */
            [
                Tile::createFromString(Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_ROAD . ":" . Tile::TILE_TYPE_GRASS),
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

        $this->assertCount(count($expectedFeatures), $features);
        $this->assertSame($expectedFeatures, $features);
    }
}
