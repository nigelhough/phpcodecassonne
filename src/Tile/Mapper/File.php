<?php
declare(strict_types=1);

namespace Codecassonne\Tile\Mapper;
use Codecassonne\Tile\Tile;

/**
 * Class Mapper
 */
Class File implements MapperInterface
{
    /** @var string Path to Tile configuration File */
    protected $tileConfigPath;

    /**
     * Construct the Data Mapper
     *
     * @param string    $tileConfigPath Path to Tile configuration File
     */
    public function __construct(string $tileConfigPath)
    {
        // Validate Configuration file
        if (!file_exists($tileConfigPath)) {
            throw new \InvalidArgumentException('Tile Configuration file must exist.');
        }
        if(!parse_ini_file($tileConfigPath)) {
            throw new \InvalidArgumentException('Unable to Parse Tile Configuration.');
        }

        $this->tileConfigPath = $tileConfigPath;
    }

    /**
     * Get All Tiles from the Configuration File
     *
     * @returns Tile[]
     */
    public function findAll(): array
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
            //Create Tile from String
            $tiles[] = Tile::createFromString($tileString);
        }

        return $tiles;

    }
}
