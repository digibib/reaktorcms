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

  $res = ($residence = $sf_guard_user->getResidence()) ? $residence->getId() : null;
  echo select_tag('sf_guard_user[residence_id]', options_for_select(ResidencePeer::getResidenceLevel(), $res, array(    
    'include_custom' => __('Choose a residence')
  ))); ?>
