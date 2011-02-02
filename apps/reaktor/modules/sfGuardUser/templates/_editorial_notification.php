<?php
/**
 * 
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
  echo select_tag('sf_guard_user[editorial_notification]', options_for_select(array(
    '0' => __('No email'),
    '1' => __('Email on first incoming artwork'),
    '2' => __('Email on all incoming artworks')),
    $sf_guard_user->getEditorialNotification()));