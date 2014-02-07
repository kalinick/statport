<?php
/**
 * User: nikk
 * Date: 2/5/14
 * Time: 1:41 PM
 */

namespace Sp\AppBundle\Model;

use Sp\AppBundle\Repository\MeetRepository;
use Sp\AppBundle\Entity\Meet;

use Doctrine\Bundle\DoctrineBundle\Registry;

class MeetManager
{
    /**
     * @var Registry
     */
    private $doctrine;
    /**
     * @var MeetRepository
     */
    private $repository;
    /**
     * @var Meet[]
     */
    private $meets;

    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->repository = $this->doctrine->getRepository('SpAppBundle:Meet');
    }

    /**
     * @return Meet[]
     */
    public function &findMeets()
    {
        if ($this->meets === null) {
            $meets = $this->repository->findAll();
            $result = [];
            foreach($meets as $meet) {
                $result[$meet->getTitle()] = $meet;
            }
            $this->meets = $result;
        }

        return $this->meets;
    }

    /**
     * @param $title
     * @param $date
     * @return Meet
     */
    public function findOrCreate($title, $date)
    {
        $meets = &$this->findMeets();
        if (!isset($meets[$title])) {
            $meet = new Meet();
            $meet->setTitle($title);
            $meet->setDate(new \DateTime($date));

            $em = $this->doctrine->getManager();
            $em->persist($meet);
            $em->flush();
            $meets[$meet->getTitle()] = $meet;
        }
        return $meets[$title];
    }
}