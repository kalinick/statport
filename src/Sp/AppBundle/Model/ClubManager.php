<?php
/**
 * User: Nikita
 * Date: 26.01.14
 * Time: 14:36
 */

namespace Sp\AppBundle\Model;

use Sp\AppBundle\Repository\ClubRepository;
use Sp\AppBundle\Entity\Club;

use Doctrine\Bundle\DoctrineBundle\Registry;

class ClubManager
{
    /**
     * @var Registry
     */
    private $doctrine;
    /**
     * @var ClubRepository
     */
    private $repository;
    /**
     * @var Club[]
     */
    private $clubs;

    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->repository = $this->doctrine->getRepository('SpAppBundle:Club');
    }

    /**
     * @return Club[]
     */
    public function &findClubs()
    {
        if ($this->clubs === null) {
            $clubs = $this->repository->findAll();
            $result = array();
            foreach($clubs as $club) {
                $result[$club->getTitle()] = $club;
            }
            $this->clubs = $result;
        }

        return $this->clubs;
    }

    /**
     * @param $title
     * @return Club
     */
    public function findOrCreate($title)
    {
        $clubs = &$this->findClubs();
        if (!isset($clubs[$title])) {
            $club = new Club();
            $club->setTitle($title);

            $em = $this->doctrine->getManager();
            $em->persist($club);
            $em->flush();
            $clubs[$club->getTitle()] = $club;
        }
        return $clubs[$title];
    }
}