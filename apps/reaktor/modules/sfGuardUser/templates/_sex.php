<?php

  /**
   * Sex partial
   *  
   * PHP version 5
   * 
   * @author    Daniel Andre Eikeland <dae@linpro.no>
   * @copyright 2008 Linpro AS
   * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
   */

  echo select_tag('sf_guard_user[sex]', options_for_select(array(
    '' => 'Please select',
    '1' => 'Male',
    '2' => 'Female'),
    $sf_guard_user->getSex()));