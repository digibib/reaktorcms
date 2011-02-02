<?php
/**
 * displays the artwork / file
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

switch($thefile->getFiletype())
{
  case('image'): 
    include_partial("slideshow", array("thefile" => $thefile, "artwork" => $artwork));
    break;
  case('video'):
    include_partial("displayPlayer", array("mode" => "video", "file" => $thefile));
    break;
  case('flash_animation'): 
    echo '<a href="' . contentPath($thefile) . '" params="lightwindow_width=850,lightwindow_height=600" class="lightwindow" author="' . 
    $thefile->getUser()->getUsername(); 
    if (!in_array($thefile->getLicense(), array('no_allow', 'contact', 'free_use', 'non_commercial', ''))) 
    { 
      echo "&nbsp;<img alt='Creative Commons License' style='border-width:0' src='http://i.creativecommons.org/l/" . 
      $thefile->getLicense() . "/3.0/no/80x15.png' width='80px' height='15px' />"; 
    } 
    echo '" caption="' . $thefile->getMetadata('description', 'abstract') . 
         '" title="' . $thefile->getTitle() . '">';
    echo image_tag(contentPath($thefile, 'thumb'));
    echo '</a><br /><br />';
    echo '<p>';
    echo __('This is an interactive Flash animation, which needs to be started manually.
            <br />Click here to start this interactive Flash animation: %link_to_launch%', 
            array('%link_to_launch%' => '<b><a href="' . contentPath($thefile) . 
                  '" class="lightwindow" author="' . $thefile->getUser()->getUsername() . 
                  ((!in_array($thefile->getLicense(), array('no_allow', 'contact', 'free_use'))) ? 
                       "&nbsp;<img alt='Creative Commons License' style='border-width:0' src='http://i.creativecommons.org/l/" . 
                       $thefile->getLicense() . "/3.0/no/80x15.png' width='80px' height='15px' />" : '') . 
                       '" params="lightwindow_width=850,lightwindow_height=600" closetext="'.__("close").'" caption="' . 
                       $thefile->getMetadata('description', 'abstract') . '" title="' . $thefile->getTitle() . '">' . 
                       __('Launch this animation') . '</a></b>'));
    echo '</p>';
    break;
  case('audio'):
    include_partial("displayPlayer", array("mode" => "audio", "file" => $thefile, 'artwork' => $artwork));
    break;
  case('pdf'):
    echo link_to(image_tag(contentPath($thefile->getId(), 'thumb')), contentPath($thefile->getId(), '', true), 
         array("title" => $thefile->getTitle()));
    break;
  case('text'):
      echo "<div id='textartwork_wrapper'>";
      echo nl2br(file_get_contents(sfConfig::get('app_artwork_content_path', '../content/') . 'text/'.$thefile->getRealpath())) ;
      echo "</div>";
    break;
  default:
    echo 'MIMETYPE NOT HANDLED!!! ' . $thefile->getMimetype() . ' ' . $thefile->getFiletype();
    break;
}
      

?>
