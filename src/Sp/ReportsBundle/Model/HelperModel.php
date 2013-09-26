<?php
/**
 * User: Nikita
 * Date: 15.09.13
 * Time: 15:23
 */

namespace Sp\ReportsBundle\Model;

use Sp\AppBundle\Entity;
use Sp\AppBundle\Repository;
use Sp\ReportsBundle\Classes\AgeInterval;

class HelperModel
{
    /**
     * @param \DateTime $birthday
     * @param \DateTime $date
     * @return string
     */
    public function getAge(\DateTime $birthday, $date = null)
    {
        if ($date == null) {
            $date = new \DateTime();
        }

        return (int) $birthday->diff($date)->format('%y');
    }

    /**
     * @param int $age
     * @return AgeInterval
     */
    public function getAgeInterval($age)
    {
        if ($age < 11) {
            return new AgeInterval(0, 10);
        } else if ($age < 13) {
            return new AgeInterval(11, 12);
        } else if ($age < 15) {
            return new AgeInterval(13, 14);
        } else if ($age < 17) {
            return new AgeInterval(15, 16);
        } else if ($age < 19) {
            return new AgeInterval(17, 18);
        }
        return new AgeInterval(19, 1000);
    }
}