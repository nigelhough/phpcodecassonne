<?php
declare(strict_types=1);

namespace Codecassonne\Map;

/**
 * Class Coordinate
 */
class Coordinate
{
    /** @var int $xCoordinate    X Coordinate */
    protected $xCoordinate;

    /** @var int $yCoordinate    Y Coordinate */
    protected $yCoordinate;

    /**
     * @param int $xCoordinate   X Coordinate
     * @param int $yCoordinate   Y Coordinate
     */
    public function __construct(int $xCoordinate, int $yCoordinate)
    {
        //Validate Passed Parameters
        if(!is_int($xCoordinate)) {
            throw new \InvalidArgumentException("X Coordinate must be an integer");
        }
        if(!is_int($yCoordinate)) {
            throw new \InvalidArgumentException("Y Coordinate must be an integer");
        }

        $this->xCoordinate = $xCoordinate;
        $this->yCoordinate = $yCoordinate;
    }

    /**
     * Convert coordinate to a string
     *
     * @return string
     */
    public function toString(): string
    {
        return $this->xCoordinate . ',' . $this->yCoordinate;
    }

    /**
     * Convert coordinate to a hash
     *
     * @return string
     */
    public function toHash(): string
    {
        return md5($this->toString());
    }

    /**
     * Compares this to another coordinate
     *
     * @param self $coordinate  Other Coordinate to compare with
     *
     * @return bool
     */
    public function isEqual(self $coordinate): bool
    {
        return ($this->toHash() === $coordinate->toHash());
    }

    /**
     * Return X Coordinate
     *
     * @return int
     */
    public function getX(): int
    {
        return $this->xCoordinate;
    }

    /**
     * Return Y Coordinate
     *
     * @return int
     */
    public function getY(): int
    {
        return $this->yCoordinate;
    }
}
