<?php
/**
 * User: Nikita
 * Date: 05.09.13
 * Time: 21:41
 */

namespace Sp\ReportsBundle\Controller;

use JMS\SecurityExtraBundle\Annotation\Secure;
use Sp\AppBundle\Entity;
use Sp\AppBundle\Model;
use Sp\ReportsBundle\Model\ReportsModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/swimmer")
 */
class SwimmerController extends Controller
{
    /**
     * @Route("/", name="reports_swimmers")
     * @Secure(roles="IS_AUTHENTICATED_REMEMBERED")
     * @Template()
     */
    public function swimmersAction()
    {
        $swimmers = array();
        foreach($this->getUser()->getChildren() as $child) {
            $swimmer = $child->getSwimmer();
            if ($swimmer !== null) {
                $swimmers[] = $swimmer;
            }
        }
        return array(
            'swimmers' => $swimmers
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
            'swimmers' => $this->getSwimmerManager()->getSwimmers(),
            'events' => $this->getEventTemplateManager()->findEventTemplates(),
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
     * @return Model\EventTemplateManager
     */
    protected function getEventTemplateManager()
    {
        return $this->get('sp_app.event_template_manager');
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