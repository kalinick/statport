<?php
/**
 * User: Nikita
 * Date: 05.09.13
 * Time: 21:41
 */

namespace Sp\ReportsBundle\Controller;

use Sp\AppBundle\Classes\ContainerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/swimmer")
 */
class SwimmerController extends Controller
{
    use ContainerTrait;

    /**
     * @Route("/", name="reports_swimmers")
     * @Template()
     */
    public function swimmersAction()
    {
        return [
            'swimmers' => $this->getSwimmerManager()->getSwimmers()
        ];
    }

    /**
     * @Route("/{id}", name="reports_swimmer")
     * @Template()
     */
    public function swimmerAction($id)
    {
        $oSwimmer = $this->getSwimmerManager()->getSwimmer($id);
        return [
            'swimmer' => $oSwimmer,
            'reportsTitles' => $this->getReportsManager()->getReportsTitles(),
            'reports' => $this->getReportsManager()->getSwimmerReports($oSwimmer)
        ];
    }
}