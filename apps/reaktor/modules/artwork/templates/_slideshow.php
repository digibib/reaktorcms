<?php
/**
 * Slideshow helper
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

  if (isset($related) && $related)
  {
    $slidetitle = __('See also');
  }
  else
  {
    $slidetitle = __('This artwork');
  }
use_helper("content");

reaktor::addJsToFooter("setTimeout(\"resizeArtworkImage('artwork_image')\", 200);");
$MAGNIFIER_ICON = image_tag('forstorre.gif', array('class' => 'magnifier_icon', 'width' => 13, 'height' => 13));

$relatedArtworks = $artwork->getRelatedArtworks(0, true);
$otherArtworks = ReaktorArtworkPeer::getArtworksByUser($artwork->getUser(), sfConfig::get("app_artwork_other_by_user", 6), true, array($artwork));

$artworks = array();
$artworks[$artwork->getId()] = $artwork;
foreach ($relatedArtworks as $anArtwork)
{
  $artworks[$anArtwork->getId()] = $anArtwork;
}
foreach ($otherArtworks as $anArtwork)
{
  $artworks[$anArtwork->getId()] = $anArtwork;
}

$theartwork = $artwork;

?>
<div id="magnify_div">
<?php
  if ($thefile->getFiletype() == 'image'):
    foreach ($artworks as $artwork):
      if ($artwork->isSlideshow()):
        foreach ($artwork->getFiles() as $slidefile):
          if ($artwork->getId() == $theartwork->getId()):
            $rel = $slidetitle.'[' . __('Watch slideshow') . ']';
          else:
            $rel = __('Other artworks').'[' . $artwork->getTitle() . ']';
          endif;
          $metadata = str_replace("'", '&lsquo;', $slidefile->getMetadata('description', 'abstract'));
          $linkto   = reaktor_link_to(__('Go to this file'), '@show_artwork_file?id=' . $artwork->getId() . '&file=' . $slidefile->getId() . '&title=' . $artwork->getTitle());
          $caption  = $metadata . "<br />" . $linkto;
          $username = $slidefile->getUser()->getUsername();
  
          $license = "";
          if (!in_array($slidefile->getLicense(), array('no_allow', 'contact', 'free_use', 'non_commercial', ''))):
            $license_img = 'http://i.creativecommons.org/l/' . $slidefile->getLicense() . '/3.0/no/80x15.png';
            $license     = "&nbsp;<img alt='Creative Commons License' style='border-width:0' src='$license_img' width='80px' height='15px' />";
          endif;
  
          // This is the artwork image (first image)
          if ($slidefile->getId() == $thefile->getId() && $theartwork->getId() == $artwork->getId()):
            echo '<p id="magnify_link">' . "\n";
            $content = __('View slideshow') . ' ' . $MAGNIFIER_ICON . image_tag(contentPath($thefile), array("id" => "artwork_image", "title" => $thefile->getTitle(), "alt" => $thefile->getTitle()));
            echo link_to($content, contentPath($slidefile, "", true), array(
                "rel"     => $rel,
                "class"   => "lightwindow",
                "author"  => $username . $license,
                "caption" => $caption,
                "title"   => $slidefile->getTitle(),
                "helptext"   => __("(if you are watching a slideshow, use the 'left' / 'right' arrow keys on your keyboard to navigate)"),
                "author_by_text" => __("by"),
                "closetext" => __("close"),
                "alt"   => $slidefile->getTitle(),
            ));
            echo "</p>\n";
          /*
           * And these are the rest of the images in the artwork.
           * Note that we don't print out any content of the link.
           * The solo purpose of this stuff is so lightwindow can pick it up
           */
          else:
            echo link_to("&nbsp;", contentPath($slidefile, "", true), array(
              "style" => "display: none;",
              "rel"   => $rel,
              "class" => "lightwindow",
              "author" => $username . $license,
              "caption" => $caption,
              "helptext"   => __("(if you are watching a slideshow, use the 'left' / 'right' arrow keys on your keyboard to navigate)"),
              "author_by_text" => __("by"),
              "closetext" => __("close"),
              "title"   => $slidefile->getTitle(),
            ));
          endif; 
        endforeach;
      else:
        $license = "";
        switch($thefile->getLicense()):
          case "free_use":
            $license = __("The author of this artwork allows all other Reactor users to freely copy this artwork"); 
            break;
          case "non_commercial":
            $license = __("The author of this artwork allows all other Reactor users to freely copy this artwork for educational or non-commercial use"); 
            break;
          case "contact":
          case "":
          case NULL:
            $license =  __("Please contact %the_author% if you want to use or copy this artwork in any way", array("%the_author%" => link_to(__('the author'), '@portfolio?user=' . $thefile->getUser()->getUsername())));
            break;
          case "no_allow":
            $license =  __("The author of this artwork does not allow any use of this artwork outside private use");
            break;
          default:
            $license_img = 'http://i.creativecommons.org/l/' . $thefile->getLicense() . '/3.0/no/80x15.png';
            $license     = "<img alt='Creative Commons License' style='border-width:0' src='$license_img' width='80px' height='15px' />";
          endswitch;
  
        if ($theartwork->getId() == $artwork->getId()):
          echo '<p id="magnify_link">' . "\n";
          $content = __("View full size") . ' ' . $MAGNIFIER_ICON . image_tag(contentPath($thefile), array("id" => "artwork_image", "title" => $thefile->getTitle(), "alt" => $thefile->getTitle()));
          echo link_to($content, contentPath($thefile, "", true), array(
            "class" => "lightwindow",
            "author" => $thefile->getUser()->getUsername() . "<br />" .$license,
            "caption" => str_replace("'", '&lsquo;', $thefile->getMetadata('description', 'abstract')),
            "title"   => $thefile->getTitle(),
            "helptext"   => __("(if you are watching a slideshow, use the 'left' / 'right' arrow keys on your keyboard to navigate)"),
            "author_by_text" => __("by"),
            "closetext" => __("close"),
            "alt"   => $thefile->getTitle(),
          ));
          echo "</p>\n";
        endif;
      endif;
    endforeach;
  endif;
?>
</div>

