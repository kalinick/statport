<?php
/**
 * User: nikk
 * Date: 2/4/14
 * Time: 4:07 PM
 */

namespace Sp\AppBundle\Model;

use Sp\AppBundle\Repository\SwimmingStyleRepository;
use Sp\AppBundle\Entity\SwimmingStyle;

use Doctrine\Bundle\DoctrineBundle\Registry;

class SwimmingStyleManager
{
    /**
     * @var Registry
     */
    private $doctrine;
    /**
     * @var SwimmingStyleRepository
     */
    private $repository;
    /**
     * @var SwimmingStyle[]
     */
    private $swimmingStyles;

    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->repository = $this->doctrine->getRepository('SpAppBundle:SwimmingStyle');
    }

    /**
     * @return SwimmingStyle[]
     */
    public function &findSwimmingStyles()
    {
        if ($this->swimmingStyles === null) {
            $swimmingStyles = $this->repository->findAll();
            $result = array();
            foreach($swimmingStyles as $swimmingStyle) {
                $result[$swimmingStyle->getTitle()] = $swimmingStyle;
            }
            $this->swimmingStyles = $result;
        }

        return $this->swimmingStyles;
    }

    /**
     * @param $title
     * @return SwimmingStyle
     */
    public function findOrCreate($title)
    {
        $swimmingStyles = &$this->findSwimmingStyles();
        if (!isset($swimmingStyles[$title])) {
            $swimmingStyle = new SwimmingStyle();
            $swimmingStyle->setTitle($title);

            $em = $this->doctrine->getManager();
            $em->persist($swimmingStyle);
            $em->flush();
            $swimmingStyles[$swimmingStyle->getTitle()] = $swimmingStyle;
        }
        return $swimmingStyles[$title];
    }
}