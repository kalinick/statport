<?php
/**
 * User: Nikita
 * Date: 05.09.13
 * Time: 21:41
 */

namespace Sp\ReportsBundle\Controller;

use Sp\AppBundle\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;

use Sp\AppBundle\Model;
use Sp\ReportsBundle\Model\ReportsModel;

/**
 * @Route("/swimmer")
 */
class SwimmerController extends Controller
{
    /**
     * @Route("/", name="reports_swimmers")
     * @Template()
     */
    public function swimmersAction()
    {
        return array(
            'swimmers' => $this->getSwimmerManager()->getSwimmers()
        );
    }

    /**
     * @Route("/{id}/show", name="reports_swimmer")
     * @Template()
     */
    public function swimmerAction($id)
    {
        $oSwimmer = $this->getSwimmerManager()->getSwimmer($id);
        return array(
            'swimmer' => $oSwimmer,
            //'swimmers' => $this->getSwimmerManager()->getSwimmers(),
            //'events' => $this->getEventManager()->findEvents(),
            'reportsTitles' => $this->getReportsManager()->getReportsTitles(),
            'reports' => $this->getReportsManager()->getSwimmerReports($oSwimmer)
        );
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

    /**
     * @return Model\EventManager
     */
    protected function getEventManager()
    {
        return $this->get('sp_app.event_manager');
    }

    /**
     * @return Model\SwimmerManager
     */
    protected function getSwimmerManager()
    {
        return $this->get('sp_app.swimmer_manager');
    }

    /**
     * @return ReportsModel
     */
    protected function getReportsManager()
    {
        return $this->get('sp_reports.reports_model');
    }
}