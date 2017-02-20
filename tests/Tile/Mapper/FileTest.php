<?php

namespace Codecassonne\Tile\Mapper;

use \Codecassonne\Tile\Tile;

class FileTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Constructor Test Provider
     */
    public function constructorProvider()
    {
        return array(
            /** Test a Valid Tiles file */
            array(
                __DIR__ . '/testTiles.ini',
                '',
                ''
            ),
            /** Test a file that doesn't exist*/
            array(
                __DIR__ . '/doesntExist.ini',
                'InvalidArgumentException',
                'Tile Configuration file must exist.'
            ),
            /** Test an invalid ini file t*/
            array(
                __DIR__ . '/invalidTiles.ini',
                'InvalidArgumentException',
                'Unable to Parse Tile Configuration.'
            ),
        );
    }

    /**
     * Test Constructing a Tile Mapper File
     *
     * @param string $testFile Test Tile File
     * @param string $expectedException Exception Exception
     * @param string $expectedExceptionMessage Expected Exception Message
     *
     * @dataProvider constructorProvider
     */
    public function testConstructor(
        $testFile,
        $expectedException,
        $expectedExceptionMessage
    )
    {
        if ($expectedException) {
            $this->expectException($expectedException, $expectedExceptionMessage);
        }
        new File($testFile);
    }

    /**
     * Data Provider for Find All Test
     *
     * @return array
     */
    public function findAllProvider()
    {
        return array(
            /** Test a Config File with one Tile */
            array(
                'tiles[] = "C:R:G:R:R"',
                array(
                    Tile::createFromString("C:R:G:R:R"),
                ),
                '',
                '',
            ),
            /** Test a Config File with multiple tiles */
            array(
                'tiles[] = "C:G:G:G:G"
                 tiles[] = "G:R:R:R:G"
                 tiles[] = "C:C:C:C:C"',
                array(
                    Tile::createFromString("C:G:G:G:G"),
                    Tile::createFromString("G:R:R:R:G"),
                    Tile::createFromString("C:C:C:C:C"),
                ),
                '',
                '',
            ),
            /** Test a Config File no tiles */
            array(
                'a = b',
                array(),
                'InvalidArgumentException',
                'Configuration File has no tiles.',
            ),
            /** Test a Config File with tiles not being an array */
            array(
                'tiles = "C:G:G:G:G"',
                array(),
                'InvalidArgumentException',
                'Configuration File has no tiles.',
            ),
        );
    }

    /**
     * @param string $fileContents Content of Tiles file
     * @param Tile[] $expectedTiles Expected Tiles to be Created
     * @param string $expectedException Exception Exception
     * @param string $expectedExceptionMessage Expected Exception Message
     *
     * @dataProvider findAllProvider
     */
    public function testFindAll(
        $fileContents,
        $expectedTiles,
        $expectedException,
        $expectedExceptionMessage
    )
    {
        //Assert any Expected Exceptions
        if ($expectedException) {
            $this->expectException($expectedException, $expectedExceptionMessage);
        }

        //Create a temp file
        $tempFilePath = $this->createTempFile($fileContents);

        //Create Test File Mapper
        $testFile = new File($tempFilePath);

        //Test Function
        $tiles = $testFile->findAll();

        //Assert Created Tiles are as expected
        foreach ($tiles as $key => $tile) {
            $this->assertSame(
                $expectedTiles[$key]->toString(),
                $tile->toString()
            );
        }
    }

    /**
     * Create a temp file and return path
     *
     * @param string $fileContents Contents of temp file
     *
     * @return string
     */
    private function createTempFile($fileContents)
    {
        //Write File
        $tempFile = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid() . '.ini';
        file_put_contents($tempFile, $fileContents);

        return $tempFile;
    }
}
