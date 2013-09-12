<?php
/**
 * User: Nikita
 * Date: 05.09.13
 * Time: 21:33
 */

namespace Sp\AppBundle\Classes;

use Sp\AppBundle\Model;
use Sp\ReportsBundle\Model\ReportsModel;

trait ContainerTrait
{
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

    protected abstract function get($id);
}