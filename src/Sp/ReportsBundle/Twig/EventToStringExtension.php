<?php
/**
 * User: Nikita
 * Date: 07.09.13
 * Time: 12:37
 */

namespace Sp\ReportsBundle\Twig;

class EventToStringExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('eventToString', array($this, 'eventToString')),
        );
    }

    /**
     * @param array $event
     * @return string
     */
    public function eventToString($event)
    {
        return $event['distance'] . ' ' . $event['style'] . ' ' . $event['course'];
    }

    public function getName()
    {
        return 'sp_event_to_string_extension';
    }
}