<?php
/**
 * User: Nikita
 * Date: 07.09.13
 * Time: 12:46
 */

namespace Sp\ReportsBundle\Twig;

class TimeToStringExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('timeToString', array($this, 'timeToString')),
        );
    }

    /**
     * @param array $time
     * @return string
     */
    public function timeToString($time)
    {
        $sResult = '';
        $hours = floor($time / 3600);
        $minutes = floor(($time % 3600) / 60);
        $seconds = $time % 60;
        $milliseconds = ($time * 100) % 100;

        if ($hours > 0 ) {
            $sResult .= str_pad($hours, 2, '0', STR_PAD_LEFT) . ':';
        }

        //if ($minutes > 0 ) {
            $sResult .= str_pad($minutes, 2, '0', STR_PAD_LEFT) . ':';
        //}

        $sResult .= str_pad($seconds, 2, '0', STR_PAD_LEFT) . '.' . str_pad($milliseconds, 2, '0', STR_PAD_RIGHT);

        return $sResult;
    }

    public function getName()
    {
        return 'sp_time_to_string_extension';
    }
}