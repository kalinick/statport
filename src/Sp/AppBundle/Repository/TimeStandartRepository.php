<?php
/**
 * User: Nikita
 * Date: 15.09.13
 * Time: 17:02
 */

namespace Sp\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

use Sp\AppBundle\Entity;

class TimeStandartRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findTimeStandartTitles()
    {
        return $this
            ->createQueryBuilder('ts')
            ->select('ts.title')
            ->getQuery()
            ->getResult();
    }
}