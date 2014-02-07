<?php
/**
 * User: nikk
 * Date: 2/4/14
 * Time: 4:02 PM
 */

namespace Sp\AppBundle\Model;

use Sp\AppBundle\Repository\DistanceRepository;
use Sp\AppBundle\Entity\Distance;

use Doctrine\Bundle\DoctrineBundle\Registry;

class DistanceManager
{
    /**
     * @var Registry
     */
    private $doctrine;
    /**
     * @var DistanceRepository
     */
    private $repository;
    /**
     * @var Distance[]
     */
    private $distances;

    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->repository = $this->doctrine->getRepository('SpAppBundle:Distance');
    }

    /**
     * @return Distance[]
     */
    public function &findDistances()
    {
        if ($this->distances === null) {
            $distances = $this->repository->findAll();
            $result = [];
            foreach($distances as $distance) {
                $result[$distance->getLength()] = $distance;
            }
            $this->distances = $result;
        }

        return $this->distances;
    }

    /**
     * @param $title
     * @return Distance
     */
    public function findOrCreate($title)
    {
        $distances = &$this->findDistances();
        if (!isset($distances[$title])) {
            $distance = new Distance();
            $distance->setLength($title);

            $em = $this->doctrine->getManager();
            $em->persist($distance);
            $em->flush();
            $distances[$distance->getLength()] = $distance;
        }
        return $distances[$title];
    }
}