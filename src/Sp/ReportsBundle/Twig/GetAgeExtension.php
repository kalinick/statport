<?php
/**
 * User: Nikita
 * Date: 15.09.13
 * Time: 15:25
 */

namespace Sp\ReportsBundle\Twig;

use Sp\ReportsBundle\Model\HelperModel;

class GetAgeExtension extends \Twig_Extension
{
    /**
     * @var HelperModel
     */
    private $helper;

    public function __construct(HelperModel $helper)
    {
        $this->helper = $helper;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('getAge', array($this, 'getAge')),
        );
    }

    /**
     * @param \DateTime $birthday
     * @return string
     */
    public function getAge(\DateTime $birthday)
    {
        return $this->helper->getAge($birthday);
    }

    public function getName()
    {
        return 'sp_get_age_extension';
    }
}