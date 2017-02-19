<?php
declare(strict_types = 1);

namespace Codecassonne\Map;

/**
 * A two dimensional Coordinate on a map
 */
class Coordinate
{
    /** @var int $xCoordinate X Coordinate */
    protected $xCoordinate;

    /** @var int $yCoordinate Y Coordinate */
    protected $yCoordinate;

    /**
     * @param int $xCoordinate X Coordinate
     * @param int $yCoordinate Y Coordinate
     */
    public function __construct(int $xCoordinate, int $yCoordinate)
    {
        $this->xCoordinate = $xCoordinate;
        $this->yCoordinate = $yCoordinate;
    }

    /**
     * Convert coordinate to a string
     *
     * @return string
     */
    public function toString()
    {
        return $this->xCoordinate . ',' . $this->yCoordinate;
    }

    /**
     * Convert coordinate to a hash
     *
     * @return string
     */
    public function toHash()
    {
        return md5($this->toString());
    }

    /**
     * Compares this to another coordinate
     *
     * @param self $coordinate Other Coordinate to compare with
     *
     * @return bool
     */
    public function isEqual(Coordinate $coordinate)
    {
        return ($this->toHash() === $coordinate->toHash());
    }

    /**
     * Return X Coordinate
     *
     * @return int
     */
    public function getX()
    {
        return $this->xCoordinate;
    }

    /**
     * Return Y Coordinate
     *
     * @return int
     */
    public function getY()
    {
        return $this->yCoordinate;
    }

    /**
     * Get coordinates that touch this coordinate
     *
     * return self[]
     */
    public function getTouchingCoordinates()
    {
        //Return offset coordinates
        return [
            'North' => new self($this->xCoordinate, $this->yCoordinate + 1),
            'East'  => new self($this->xCoordinate + 1, $this->yCoordinate),
            'South' => new self($this->xCoordinate, $this->yCoordinate - 1),
            'West'  => new self($this->xCoordinate - 1, $this->yCoordinate),
        ];
    }

    /**
     * Get coordinates that surround this coordinate
     *
     * return self[]
     */
    public function getSurroundingCoordinates()
    {
        //Return offset coordinates
        return [
            'North West' => new self($this->xCoordinate - 1, $this->yCoordinate + 1),
            'North'      => new self($this->xCoordinate, $this->yCoordinate + 1),
            'North East' => new self($this->xCoordinate + 1, $this->yCoordinate + 1),
            'West'       => new self($this->xCoordinate - 1, $this->yCoordinate),
            'East'       => new self($this->xCoordinate + 1, $this->yCoordinate),
            'South West' => new self($this->xCoordinate - 1, $this->yCoordinate - 1),
            'South'      => new self($this->xCoordinate, $this->yCoordinate - 1),
            'South East' => new self($this->xCoordinate + 1, $this->yCoordinate - 1),
        ];
    }

    /**
     * Get a Coordinate at a bearing relative to this coordinate
     *
     * @param string $bearing Bearing relative to this coordinate
     *
     * @return Coordinate
     * @throws \Exception   Invalid bearing passed
     */
    public function getBearing(string $bearing)
    {
        switch ($bearing) {
            case 'North West':
                return new self($this->xCoordinate - 1, $this->yCoordinate + 1);
                break;
            case 'North':
                return new self($this->xCoordinate, $this->yCoordinate + 1);
                break;
            case 'North East':
                return new self($this->xCoordinate + 1, $this->yCoordinate + 1);
                break;
            case 'West':
                return new self($this->xCoordinate - 1, $this->yCoordinate);
                break;
            case 'East':
                return new self($this->xCoordinate + 1, $this->yCoordinate);
                break;
            case 'South West':
                return new self($this->xCoordinate - 1, $this->yCoordinate - 1);
                break;
            case 'South':
                return new self($this->xCoordinate, $this->yCoordinate - 1);
                break;
            case 'South East':
                return new self($this->xCoordinate + 1, $this->yCoordinate - 1);
                break;
        }

        throw new Exception\InvalidBearing('Invalid Bearing');
    }
}
