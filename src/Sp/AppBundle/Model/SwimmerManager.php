<?php
/**
 * User: Nikita
 * Date: 05.09.13
 * Time: 21:26
 */

namespace Sp\AppBundle\Model;

use Sp\AppBundle\Repository;
use Sp\AppBundle\Entity;

use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Registry;

class SwimmerManager
{
    /**
     * @var Registry
     */
    private $doctrine;

    /**
     * @var Repository\SwimmerRepository
     */
    private $repository;

    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->repository = $this->doctrine->getRepository('SpAppBundle:Swimmer');
    }

    /**
     * @return Entity\Swimmer[]
     */
    public function getSwimmers()
    {
        return $this->repository->findAll();
    }

    /**
     * @param int $id
     * @return Entity\Swimmer
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function getSwimmer($id)
    {
        $oSwimmer = $this->repository->find($id);

        if (! $oSwimmer instanceof Entity\Swimmer) {
            throw new EntityNotFoundException();
        }

        return $oSwimmer;
    }
}