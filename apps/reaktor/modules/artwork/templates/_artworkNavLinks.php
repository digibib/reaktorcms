<?
/**
 * Navigation links for artworks, for navigation to next, previous, first and last files
 * Will display active links or greyed out links as necessary
 * 
 * - $artwork: The artwork object that we need links for
 * - $thefile: The file object of the current file
 * - $class: The optional class of the container div (default "artwork_nav_links")
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
?>

<div class =<?php echo isset($class) ? $class : 'artwork_nav_links'; ?>>
	<div class="left">
    <?php if ($prevfile = $artwork->getPreviousFile($thefile->getId())): ?>
      <?php echo reaktor_link_to(image_tag("/sf/images/sf_admin/first.png", array( 
                         "onMouseOver" => ("Tip('".__("Go to first file: %title%", array("%title%" => $artwork->getFirstFile()->getTitle()."');"))),
                         "onMouseOut" => "UnTip();")),
                         $artwork->getLink('show', $artwork->getFirstFile()->getId())); ?>
      <?php echo reaktor_link_to(image_tag("/sf/images/sf_admin/previous.png", array( 
                         "onMouseOver" => ("Tip('".__("Go to previous file: %title%", array("%title%" => $prevfile->getTitle()."');"))),
                         "onMouseOut" => "UnTip();")),
                       $artwork->getLink('show', $prevfile->getId())); ?>
      
    <?php else: ?>
      <?php echo image_tag('first_grey.png'); ?>
    	<?php echo image_tag('previous_grey.png'); ?>
    <?php endif; ?>
  </div>
  <div class ="right">
    <?php if ($nextfile = $artwork->getNextFile($thefile->getId())): ?>
      <?php echo reaktor_link_to(image_tag("/sf/images/sf_admin/next.png", array( 
                         "onMouseOver" => ("Tip('".__("Go to next file: %title%", array("%title%" => $nextfile->getTitle()."');"))),
                         "onMouseOut" => "UnTip();")),
                         $artwork->getLink('show', $nextfile->getId())); ?>
      <?php echo reaktor_link_to(image_tag("/sf/images/sf_admin/last.png", array( 
                         "onMouseOver" => ("Tip('".__("Go to last file: %title%", array("%title%" => $artwork->getLastFile()->getTitle()."');"))),
                         "onMouseOut" => "UnTip();")), 
                         $artwork->getLink('show', $artwork->getLastFile()->getId())); ?>
    <?php else: ?>
    	<?php echo image_tag('next_grey.png'); ?>
    	<?php echo image_tag('last_grey.png'); ?>
    <?php endif; ?>
	</div>
</div>