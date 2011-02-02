<?php
/**
 * Status buttons for artwork
 * These buttons provide the ability to switch hidden status and remove an artwork completely  
 * Variable required:
 * - $artwork : The artwork object 
 * 
 * PHP Version 5
 *
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
?>
<?php if (!isset($nostatus)): ?>
  <h2><?php echo __("Artwork status"); ?></h2>
  <p><?php include_partial("statusRow", array("artwork" => $artwork)); ?></p>
  <?php if ($artwork->isDraft()): ?>
  	<p><?php echo __("When you are happy with your artwork, click 'Submit this artwork' to submit it for approval"); ?></p>
  <?php endif; ?>
  
  <br />
<?php endif; ?>
<div style = "text-align: right; width: 100%;">
	<?php if ($artwork->isDraft() || $artwork->isRejected()): ?>
    <?php echo reaktor_form_tag("@edit_artwork?id=".$artwork->getId(), array('class' => 'clearnone inline')); ?> 
      <?php echo submit_tag(__("Submit this artwork for approval"), array("name" => "submit_artwork")); ?>  
    <?php echo '</form>'; ?>
  <?php endif; ?>
  <?php if (!$artwork->isRemoved()): ?>
    <?php echo button_to_remote(__("Remove this artwork"), array(   
          'update'=> "artwork_".$artwork->getId(),
          'complete' => $sf_user->hasCredential("editusercontent") ? "location.reload();" : "window.location='".url_for("@my_content?mode=menu")."'",
          'url' => '@artwork_status?status=5&id='.$artwork->getId(),
          'confirm' => __("You are about to completely remove this artwork, are you sure?"),
          ), array("id" => "remove_button_".$artwork->getId())); ?>
  <?php elseif ($sf_user->hasCredential("editusercontent")): ?>
  	<?php echo button_to_remote(__("Restore this artwork"), array(   
          'update'=> "artwork_".$artwork->getId(),
  	      'complete' => "location.reload();",
          'url' => '@artwork_status?status=1&id='.$artwork->getId(),
          'confirm' => __("You are about to restore this artwork to draft status, ".
  	                      "this will also restore any files in this artwork that were hidden. ".
  	                      "the user may be under the impression that these files were deleted. Are you sure?"),
          ), array("id" => "restore_button_".$artwork->getId())); ?>
  <?php endif; ?>
  <?php if ($artwork->isApproved()): ?>
    <?php echo button_to_remote(__("Disable this artwork"), array(   
          'update'=> "artwork_".$artwork->getId(),
          'complete' => "location.reload();",
          'url' => '@artwork_status?status=6&id='.$artwork->getId(),
          'confirm' => __("Hide this artwork temporarily?"),
          ), array("id" => "disable_button_".$artwork->getId())); ?>
  <?php elseif ($artwork->isApprovedHidden()): ?>
    <?php echo button_to_remote(__("Enable this artwork"), array(   
          'update'=> "artwork_".$artwork->getId(),
          'complete' => "location.reload();",
          'url' => '@artwork_status?status=3&id='.$artwork->getId(),
          'confirm' => __("Restore this artwork for public viewing?"),
          ), array("id" => "enable_button_".$artwork->getId())); ?>
  <?php endif; ?>
</div>