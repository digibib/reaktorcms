<?php

/**
 * Event listener for sfGoogleAnalyticsPlugin.
 * 
 * @package     sfGoogleAnalyticsPlugin
 * @subpackage  listener
 * @author      Kris Wallsmith <kris [dot] wallsmith [at] gmail [dot] com>
 * @version     SVN: $Id: sfGoogleAnalyticsListener.class.php 8635 2008-04-26 23:23:23Z Kris.Wallsmith $
 */
class sfGoogleAnalyticsListener
{
  /**
   * Get the current tracker object.
   * 
   * @param   sfEvent $event
   * 
   * @return  bool
   */
  public static function observe(sfEvent $event)
  {
    $subject = $event->getSubject();
    
    switch ($event['method'])
    {
      case 'getTracker':
      $event->setReturnValue(sfGoogleAnalyticsMixin::getTracker($subject));
      return true;
      
      case 'setTracker':
      sfGoogleAnalyticsMixin::setTracker($subject, $event['arguments'][0]);
      return true;
    }
  }
  
}
