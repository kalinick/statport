<?php
/**
 * User: nikk
 * Date: 2/5/14
 * Time: 2:23 PM
 */

namespace Sp\AppBundle\Model;

use Doctrine\ORM\EntityNotFoundException;
use Sp\AppBundle\Repository\EventTemplateRepository;
use Sp\AppBundle\Entity\EventTemplate;

use Doctrine\Bundle\DoctrineBundle\Registry;

class EventTemplateManager
{
    /**
     * @var Registry
     */
    private $doctrine;
    /**
     * @var EventTemplateRepository
     */
    private $repository;
    /**
     * @var EventTemplate[]
     */
    private $eventTemplates;

    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->repository = $this->doctrine->getRepository('SpAppBundle:EventTemplate');
    }

    /**
     * @return EventTemplate[]
     */
    public function &findEventTemplates()
    {
        if ($this->eventTemplates === null) {
            $eventTemplates = $this->repository->findAll();
            $result = array();
            foreach($eventTemplates as $eventTemplate) {
                $result[$eventTemplate->getTitle()] = $eventTemplate;
            }
            $this->eventTemplates = $result;
        }

        return $this->eventTemplates;
    }

    /**
     * @param $title
     *
     * @return EventTemplate
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function findByTitle($title)
    {
        $eventTemplates = &$this->findEventTemplates();
        if (!isset($eventTemplates[$title])) {
            throw new EntityNotFoundException('Event template with title "' . $title . '" not found');
        }
        return $eventTemplates[$title];
    }
}