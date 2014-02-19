<?php
/**
 * User: nikk
 * Date: 2/6/14
 * Time: 12:17 PM
 */

namespace Sp\AppBundle\Model;

use Sp\AppBundle\Repository\LscRepository;
use Sp\AppBundle\Entity\Lsc;

use Doctrine\Bundle\DoctrineBundle\Registry;

class LscManager
{
    /**
     * @var Registry
     */
    private $doctrine;
    /**
     * @var LscRepository
     */
    private $repository;
    /**
     * @var Lsc[]
     */
    private $lscs;

    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->repository = $this->doctrine->getRepository('SpAppBundle:Lsc');
    }

    /**
     * @return Lsc[]
     */
    public function &findLscs()
    {
        if ($this->lscs === null) {
            $lscs = $this->repository->findAll();
            $result = array();
            foreach($lscs as $lsc) {
                $result[$lsc->getTitle()] = $lsc;
            }
            $this->lscs = $result;
        }

        return $this->lscs;
    }

    /**
     * @param $title
     * @return Lsc
     */
    public function findOrCreate($title)
    {
        $lscs = &$this->findLscs();
        if (!isset($lscs[$title])) {
            $lsc = new Lsc();
            $lsc->setTitle($title);

            $em = $this->doctrine->getManager();
            $em->persist($lsc);
            $em->flush();
            $lscs[$lsc->getTitle()] = $lsc;
        }
        return $lscs[$title];
    }
}