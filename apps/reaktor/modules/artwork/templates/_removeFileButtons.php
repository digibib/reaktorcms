<?php
/**
 * The sliding div that appears when remove/unlink file is clicked
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
use_helper("Javascript");
?>
<br style = "clear: both;" />
<div id = "remove_file_buttons_<?php echo $thisFile->getId()?>" style = "display: none;">
  <ul class = "bulletlist indented">
    <?php if ($sf_user->hasCredential("editusercontent")): ?>
    <li class ="admin_link">
      <?php echo reaktor_link_to(__('Remove and mark this file unsuitable [moderator]'), 
        "@removefilemessage?id=".$thisFile->getId()."&artworkId=".$artwork->getID(),
        array("confirm" => __("This will remove the file from the artwork, and mark it as unsuitable content. Continue?"), 
        "class" => 'admin_link')) ?></li>
    <?php endif; ?>
		<li>
      <?php echo reaktor_link_to(__('Remove and create new artwork using this file'), 
        "@remove_file_create?fileId=".$thisFile->getId()."&artworkId=".$artwork->getID(),
        array("confirm" => __("A new artwork will be created and submitted for approval, continue?"))) ?></li>
			<li>
      <?php echo reaktor_link_to(__('Remove and link to a different artwork'), 
        "@remove_file_link?fileId=".$thisFile->getId()."&artworkId=".$artwork->getID(), 
        array("confirm" => __("On the next page, select an eligible artwork from the 'save and attach to previous artwork' section, and click 'Link to selected artwork'"))) ?></li>
			<li>
      <?php echo reaktor_link_to(__('Just remove for now (will be available on your uploaded files page)'), 
        "@remove_artwork_file?fileId=".$thisFile->getId()."&artworkId=".$artwork->getID(),
        array("confirm" => __("Are you sure? You can re-link this file at any time by selecting 'edit' from your uploaded file page"))) ?></li>
		<li>
      <?php echo link_to_function(__('Cancel'), 
      visual_effect('toggle_slide', 'remove_file_buttons_'.$thisFile->getId())) ?></li>
	</ul>
</div>