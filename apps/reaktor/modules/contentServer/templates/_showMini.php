<?php
 /**
 * Show a mini thumbnail for an artwork object with or without mouseover
 * Include this partial with the artwork object as a parameter and the "mini" thumb will automatically be displayed
 * along with a link to the artwork and a mouseover with title, username and current rating.
 * 
 * - $nomouseover : Set true to disable the mouseover effect which is on by default
 * - $artwork     : The artwork object - everything is automatically derived from this
 * - $nolink      : Set true to do not display the link, only the thumbnail
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

// Generate the mouseover tooltip if any
if (!isset($nomouseover) || !$nomouseover):
  $thisMouseover  = "Tip('<div class = \'tool_tip_internal\'><h3>".addslashes($artwork->getTitle())."</h3>";
  if (!$artwork->isMultiUser())
  {
    $thisMouseover .= __("by")." ".$artwork->getUser()->getUsername()."<br />";
  }
  $thisMouseover .= __('Created on: %creation_date%', array('%creation_date%' => date("d/m/Y", strtotime($artwork->getCreatedAt()))))."<br /><br />";
  $thisMouseover .= get_partial('artwork/artworkRating', array('artwork' => $artwork, 'noedit' => false, 'login' => false))."</div>', FADEIN, 300, BGCOLOR, '#FFFFFF')";
  $thisMouseout   = "UnTip()";
else:
  $thisMouseover = "";
  $thisMouseout = "";
endif;
$relative = isset($relative) ? $relative : false;

// Display the thumbnail on the page
if (!isset($nolink) || $nolink == false):
echo reaktor_link_to(image_tag(contentPath($artwork, "mini"), array('size' => '78x65', 'alt' => $artwork->getTitle(), 'title' => $artwork->getTitle(), 'absolute' => !$relative)), 
    $artwork->getLink(), array(
    'onmouseover' => $thisMouseover,
    'onmouseout'  => $thisMouseout,
    'absolute'    => !$relative,
));
else:
  echo image_tag(contentPath($artwork, "mini"), array('size' => '78x65', 'alt' => $artwork->getTitle(), 'title' => $artwork->getTitle()));
endif;

