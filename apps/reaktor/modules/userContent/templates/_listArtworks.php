<?php
/**
 * Simple list of artworks for use on file lists and ajax callbacks
 *
 * - $file : The file object that we are generating the list from
 * 
 * PHP Version 5
 *
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
$first = true;
?>

<?php if ($file->countParentArtworks()): ?>
	<?php echo '<b>' . __("Part of: %list_of_artworks%", array("%list_of_artworks%" => "</b>")); ?>  
  <?php foreach ($file->getParentArtworks() as $artwork): ?>
  	<?php if (!$artwork->isMultiUser() || $artwork->isApproved() || $sf_user->hasCredential("viewallcontent")): ?>
      <?php echo ($first) ? "" : ", "; ?>
      <?php echo reaktor_link_to($artwork->getTitle(), "@show_artwork?title=".$artwork->getTitle()."&id=".$artwork->getId()); ?>
      <?php $first = false; ?>
    <?php endif; ?>
  <?php endforeach; ?>
<?php else: ?>
	<?php echo '<b>' . __('Part of: %list_of_artworks%', array('%list_of_artworks%' => '</b>' . __("No artworks"))); ?>
<?php endif; ?>