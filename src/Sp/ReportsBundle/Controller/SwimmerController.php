<?php
/**
 * User: Nikita
 * Date: 05.09.13
 * Time: 21:41
 */

namespace Sp\ReportsBundle\Controller;

use Sp\AppBundle\Classes\ContainerTrait;
use Sp\AppBundle\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;

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
     * @Route("/{id}/show", name="reports_swimmer")
     * @Template()
     */
    public function swimmerAction($id)
    {
        $oSwimmer = $this->getSwimmerManager()->getSwimmer($id);
        return [
            'swimmer' => $oSwimmer,
            'swimmers' => $this->getSwimmerManager()->getSwimmers(),
            'events' => $this->getEventManager()->findEvents(),
            'reportsTitles' => $this->getReportsManager()->getReportsTitles(),
            'reports' => $this->getReportsManager()->getSwimmerReports($oSwimmer)
        ];
    }

    /**
     * @Route("/{id}/compare-swimmer", name="reports_compare_swimmer")
     */
    public function compareSwimmerAction($id)
    {
        $swimmer = $this->getRequest()->get('swimmer');
        $event = $this->getRequest()->get('event');

        $aResult = $this->getReportsManager()->getSwimmerToSwimmerReport($id, $swimmer, $event);
        $aResult['myName'] = (string) $this->getSwimmerManager()->getSwimmer($id);
        $aResult['swimmerName'] = (string) $this->getSwimmerManager()->getSwimmer($swimmer);
        return new JsonResponse($aResult);
    }
}