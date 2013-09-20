<?php
/**
 * User: Nikita
 * Date: 15.09.13
 * Time: 15:23
 */

namespace Sp\ReportsBundle\Model;

use Sp\AppBundle\Entity;
use Sp\AppBundle\Repository;

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
}