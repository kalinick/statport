<?php
/**
 * User: Nikita
 * Date: 05.09.13
 * Time: 21:26
 */

namespace Sp\AppBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @return Repository\EventResultRepository
     */
    public function getEventResultRepository()
    {
        return $this->doctrine->getRepository('SpAppBundle:EventResult');
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

    /**
     * @param Entity\UserChild[] $children
     */
    public function assignSwimmersToChildren($children)
    {
        foreach($children as $child) {
            $swimmer = $this->repository->findByFirstLastName($child->getFirstName(), $child->getLastName());
            if ($swimmer instanceof Entity\Swimmer) {
                $child->setSwimmer($swimmer);
                if ($swimmer->getBirthday() === null) {
                    $swimmer->setBirthday($child->getBirthday());

                    foreach($this->getEventResultRepository()->findBySwimmer($swimmer) as $result) {
                        $age = $result->getEvent()->getMeet()->getDate()->diff($swimmer->getBirthday())->format('%y');
                        $result->setAge($age);
                    }
                }
            }
        }

        $this->doctrine->getManager()->flush();
    }
}