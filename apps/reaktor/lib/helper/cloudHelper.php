<?php
/**
 * tag cloud helper
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

/**
 * Generates a tag cload
 *
 * @param Array  $tags    Hash with tag name as keys and FIX as value
 * @param String $route   A route as given to link_to()
 * @param Array  $options FIX
 *
 * @return String the cloud
 */
function tag_cloud_with_count($tags, $route, $options = array(), $title = '')
{
  
	$result = '';
	if ($title != '')
	{
    $result .= '<div class="tag_cloud_header"><h2>' . $title . '</h2></div>';
	}
  
  if (count($tags) > 0)
  {
    $emphasizers_begin = array(-2 => '<small><small>', 
                               -1 => '<small>', 
                                0 => '', 
                                1 => '<big>', 
                                2 => '<big><big>');
    $emphasizers_end   = array(-2 => '</small></small>', 
                               -1 => '</small>', 
                                0 => '', 
                                1 => '</big>', 
                                2 => '</big></big>');

    $class  = isset($options['class']) ? $options['class'] : 'tag-cloud';
    $result .= '<ul class="'.$class.'">';

    foreach ($tags as $name => $valuesArray)
    {
      if ($valuesArray['count'] > 0 || isset($options['detailed']))
      {
        $linktext  = '';
        $linktext .= (!isset($options['detailed'])) 
          ? $emphasizers_begin[$valuesArray["emphasisValue"]].$valuesArray["displayName"].$emphasizers_end[$valuesArray["emphasisValue"]] 
          : $name;

        $linktext .= (!isset($options['detailed'])) 
          ? '<span style="font-size: ' . (0.8 + ($valuesArray['emphasisValue'] / 10)) . 'em;">(' . $valuesArray['count'] . ')</span>'
          : '';
        $link      = reaktor_link_to($linktext, $route.$valuesArray["displayName"], array('rel' => 'tag'));
        $result   .= ' <li>'.$link.'&nbsp;';
        $result   .= (isset($options['detailed']))
          ? ' ' . $valuesArray['count'] . ' items in this category' 
          : '';
        $result   .= '</li>';
      }
    }

    $result .= '</ul>';
  }

  return $result;
}
