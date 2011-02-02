<?php
/**
 * Wrapper for dragging and dropping from one file list to another as an easy way to make galleries from uploaded files
 *
 * PHP Version 5
 *
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
use_helper("content", "Javascript");
$title       = __("Manage files in %artwork_title%", array("%artwork_title%" => $linkArtwork->getTitle()));

reaktor::setReaktorTitle($title);
?>

<div id ="user_artwork_list">
  <h2><?php echo __("Files currently in %artwork_title%", 
       array("%artwork_title%" => reaktor_link_to($linkArtwork->getTitle(), 
             "@show_artwork?id=".$linkArtwork->getId()."&title=".$linkArtwork->getTitle()))); ?></h2>
  <?php echo " [ ".reaktor_link_to(__("edit"), "@edit_artwork?id=".$linkArtwork->getId())." ]"; ?>
  <?php echo " [ ".reaktor_link_to(__("back to 'manage my content' menu"), $route."?user=".$thisUser->getUsername()."&mode=menu")." ]"; ?>
  <br />
  <p><?php echo __("Click the thumbnails and drag the files to order them - the top file will define your artwork thumbnail"); ?></p>
  <div id = "artwork_collection_files">
    <?php include_partial("simpleFileListForAjax", array("artworkFiles" => $artworkFiles, "button" => "delete", "linkArtwork" => $linkArtwork, "thisUser" => $thisUser, "allowOrdering" => true)); ?>
  </div>
  <br />
  <h2><?php echo __("Available files that can be added to this %collection_type%", 
               array("%collection_type%" => collectionType($linkArtwork))); ?></h2>
      <?php echo " [ ".reaktor_link_to(__("upload more"), "@artwork_link?link_artwork_id=".$linkArtwork->getId()); ?>
      <?php if (sfConfig::get("admin_mode") && $sf_user->hasCredential("createcompositeartwork")): ?>
        <?php if ($sf_params->get("allusers")): ?>
        	<?php  echo " / ".link_to(__("Show files from original user"), "@admin_link_existing_file?user=".$linkArtwork->getUser()->getUsername()."&artworkId=".$linkArtwork->getId()); ?>
        <?php else: ?>
          <?php  echo " / ".link_to(__("Show files from all users"), "@admin_link_existing_file_allusers?user=".$thisUser."&artworkId=".$linkArtwork->getId(), array("confirm" => __("If you add files from other users, this artwork will become a composite (multi-user) artwork"))); ?>
        <?php endif; ?>
      <?php endif; ?>
      <?php echo " ]"; ?>
      <br/>
  <div id = "artwork_eligible_files">
    <?php include_partial("simpleFileListForAjax", array("artworkFiles" => $eligibleFiles, "button" => "add", "linkArtwork" => $linkArtwork,  "thisUser" => $thisUser)); ?>
  </div>
</div>