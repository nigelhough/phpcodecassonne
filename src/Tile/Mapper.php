<?php

namespace Codecassonne\Tile;

/**
 * Class Mapper
 */
Class Mapper
{
    /** @var string Path to Tile configuration File */
    protected $tileConfigPath;

    /** @var Factory Factory to create Tiles */
    protected $tileFactory;

    /**
     * Construct the Data Mapper
     *
     * @param string    $tileConfigPath Path to Tile configuration File
     * @param Factory   $tileFactory    Factory to create Tiles
     */
    public function __construct($tileConfigPath, Factory $tileFactory)
    {
        // Validate Configuration file
        if (!file_exists($tileConfigPath)) {
            throw new \InvalidArgumentException('Tile Configuration file must exist.');
        }
        if(!parse_ini_file($tileConfigPath)) {
            throw new \InvalidArgumentException('Unable to Parse Tile Configuration.');
        }

        $this->tileConfigPath = $tileConfigPath;
        $this->tileFactory = $tileFactory;
    }

    /**
     * Get All Tiles from the Configuration File
     *
     * @returns Tile[]
     */
    public function findAll()
    {
        // Parse the config File
        $tileDetails = parse_ini_file($this->tileConfigPath);

        // Check the file is valid
        if(
            !isset($tileDetails['tiles']) ||
            !is_array($tileDetails['tiles']) ||
            empty($tileDetails['tiles'])
        ) {
            throw new \InvalidArgumentException('Configuration File has no tiles.');
        }

        //Initialise Tiles Array
        $tiles = array();

        //Iterate over Tiles in config file
        foreach($tileDetails['tiles'] as $tileString)
        {
            //Create Tile Faces from String
            $tileFaces = Faces::createFromString($tileString);

            //Create Tile with factory from Tile Faces
            $tiles[] = $this->tileFactory->create($tileFaces);
        }

        return $tiles;

    }
}
