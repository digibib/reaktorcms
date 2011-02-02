<?php
/**
 * date helper, to convert seconds to date
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */


function format_duration($seconds) {

    $periods = array(
        'centuries' => 3155692600,
        'decades' => 315569260,
        'years' => 31556926,
        'months' => 2629743,
        'weeks' => 604800,
        'days' => 86400,
        'hours' => 3600,
        'minutes' => 60,
        'seconds' => 1
    );

    $durations = array();

    foreach ($periods as $period => $seconds_in_period) {
        if ($seconds >= $seconds_in_period) {
            $durations[$period] = floor($seconds / $seconds_in_period);
            $seconds -= $durations[$period] * $seconds_in_period;
        }
        else
        {
        	$durations[$period] = 0;
        }
    }
   
    return $durations;

}

?>
