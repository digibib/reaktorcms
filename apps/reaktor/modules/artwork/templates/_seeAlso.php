
<?php
/**
 * The related artwork list to be displayed on the show artwork page
 * Also known as "see also". Example of use:
 * 
 *  include_component('artwork', 'seeAlso', array(
 *    'artwork'     => $artwork,
 *    'update'      => 'relate_artwork_tag',
 *    'editmode'    => $editmode,
 *    'usercanedit' => $usercanedit));
 * 
 * $artwork:     genericArtwork object, the artwork currently viewed
 * $update:      the div that should be updated
 * $editmode:    the artwork view mode (show|edit)
 * $usercanedit: the user has proper credentials? (true|false)
 * 
 * The controller passes the following information:
 * $relatedArtworks: array of genericArtwork objects
 * $otherpeoplelike: array of genericArtwork objects
 * otherArtworks:    array of genericArtwork objects
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

use_helper("content");

?>
<?php if (!empty($relatedArtworks)): ?>
  <h4><?php echo __("See also: ")?></h4> 
  <div id="related_artwork_imagelist">
    <?php foreach($relatedArtworks as $thisArtwork): ?>      
      <?php echo showMiniThumb($thisArtwork) ?> 
      <?php if($editmode&&$usercanedit): ?>          
        <?php echo link_to_remote(image_tag('delete.png', 'alt=delete.png size=10x10'), array(
              'update'   => $update, 
              'url'      => '@removeartworkrelation?viewartwork='.$artwork->getId().'&relatedartwork='.$thisArtwork->getId(),
              //'loading'  => "Element.show('resource_ajax_indicator')",
              //'complete' => "Element.hide('resource_ajax_indicator')",
              'script'   => true,
            )) ?>
      <?php endif ?>
    <?php endforeach; ?>
  </div>
  <?php if ($editmode && $usercanedit && $sf_user->hasCredential("createcompositeartwork")): ?>
  <div id="crosslink_div" class="topborder">
    <?php echo link_to_remote(__("Cross relate all these artworks"), array(
      'url'    => '@crosslink_all_artworks?id=' .$artwork->getId(),
      'loading'  => "Element.show('relate_artwork_ajax_indicator')",
      'complete' => "Element.hide('relate_artwork_ajax_indicator')",
      'success'  => "Element.show('related_ok')",
      'script'   => true,
    ));
    ?>
    <div id="related_ok" style="display:none">
      <?php echo __("Done."); ?>
    </div>
  </div>
  <?php endif; ?>

<?php elseif (!empty($otherArtworks) && !$editmode && !$artwork->isMultiUser()): ?>
  <h4><?php echo __("More work by")." ".$artwork->getUser()->getUsername();?></h4>
  <div id="related_artwork_imagelist">
	  <?php foreach($otherArtworks as $thisArtwork): ?>
	    <?php echo showMiniThumb($thisArtwork) ?>
	  <?php endforeach; ?>
  </div>
<?php endif; ?>
<?php if (!empty($otherpeoplelike)): ?>
  <h4><?php echo __("Users who like this artwork also like:")?></h4>
  <div id="related_otherpeople_artwork_imagelist">
    <?php foreach($otherpeoplelike as $thisArtwork): ?>
      <?php echo showMiniThumb($thisArtwork) ?> 
    <?php endforeach ?>
  </div>
<?php endif ?>

