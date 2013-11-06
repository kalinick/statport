<?php
/**
 * User: Nikita
 * Date: 22.09.13
 * Time: 11:08
 */

namespace Sp\ReportsBundle\Classes;

class AgeInterval
{
    const MYSQL_FORMAT = 'Y-m-d H:i:s';

    /**
     * @var int
     */
    private $minAge;

    /**
     * @var int
     */
    private $maxAge;

    public function __construct($minAge, $maxAge)
    {
        $this->minAge = $minAge;
        $this->maxAge = $maxAge;
    }

    /**
     * @param int $minAge
     * @return AgeInterval
     */
    public function setMinAge($minAge)
    {
        $this->minAge = $minAge;

        return $this;
    }

    /**
     * @return int
     */
    public function getMinAge()
    {
        return $this->minAge;
    }

    /**
     * @return \DateTime
     */
    public function getMaxBirthday()
    {
        return new \DateTime('now - ' . ($this->minAge - 1) . ' year');
    }

    /**
     * @return string
     */
    public function getMaxBirthdayAsString()
    {
        return $this->getMaxBirthday()->format(self::MYSQL_FORMAT);
    }

    /**
     * @param int $maxAge
     * @return AgeInterval
     */
    public function setMaxAge($maxAge)
    {
        $this->maxAge = $maxAge;

        return $this;
    }

    /**
     * @return int
     */
    public function getMaxAge()
    {
        return $this->maxAge;
    }

    /**
     * @return \DateTime
     */
    public function getMinBirthday()
    {
        return new \DateTime('now - ' . $this->maxAge . ' year');
    }

    /**
     * @return string
     */
    public function getMinBirthdayAsString()
    {
        return $this->getMinBirthday()->format(self::MYSQL_FORMAT);
    }
}