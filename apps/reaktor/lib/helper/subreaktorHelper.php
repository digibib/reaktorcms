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

function reaktor_url_for($internal_uri, $absolute = false)
{
  $internal_uri = Subreaktor::addSubreaktorToRoute($internal_uri);
  return url_for($internal_uri, $absolute);
}

function reaktor_link_to($name = '', $internal_uri = '', $options = array())
{
  $internal_uri = Subreaktor::addSubreaktorToRoute($internal_uri);
  return link_to($name, $internal_uri, $options);
}

function reaktor_button_to($name = '', $internal_uri = '', $options = array())
{
  $internal_uri = Subreaktor::addSubreaktorToRoute($internal_uri);
  return button_to($name, $internal_uri, $options);
}

function reaktor_form_tag($internal_uri = '', $options = array())
{
  $internal_uri = Subreaktor::addSubreaktorToRoute($internal_uri);
  return form_tag($internal_uri, $options);
}

?>