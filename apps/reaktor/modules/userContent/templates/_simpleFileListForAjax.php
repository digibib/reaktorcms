<?php
/**
 * Simple file list partial, for updating ajax responses
 * - $allowOrdering : If true the top list is draggable for ordering files in the artwork
 * - $linkArtwork   : The artwork object
 * - $thisUser      : The user object we are working with
 * 
 * PHP Version 5
 *
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

use_helper("Javascript", "content");
$admin = (sfConfig::get("admin_mode")) ? "admin" : "";
?>

<ul id = "artwork_files">
  <?php foreach ($artworkFiles as $file): ?>
    <?php if ($button == "add"): ?>
      <li id = "bottom_<?php echo $file->getId(); ?>">
        <?php $confirm = ($linkArtwork->isApproved() && !$sf_user->hasCredential("editusercontent")) ? "confirm" : "noconfirm"; ?>
        <?php $extraButton = button_to_remote(__('Add to %collection_type%', array("%collection_type%" => collectionType($linkArtwork))), 
                array(   
                  'url'         => "@".$admin."addToCollection?user=".$thisUser->getUsername()."&artworkId=".$linkArtwork->getId()."&fileId=".$file->getId(),
                  'complete'    => "removeButtons++;Effect.BlindUp('bottom_".$file->getId()."');",
                  'update'      => "artwork_collection_files",
                  $confirm      => ($linkArtwork->isApproved() ? __("Warning - you are adding files to an approved artwork. Adding this file to your artwork will force the artwork to be resubmitted for approval by the editorial staff, continue?") : ""),
                  'script'      => true),
                array("class" => "")); ?>
    <?php else: ?>
      <li id = "file_<?php echo $file->getId(); ?>">
        <?php $extraButton = button_to_remote(__('Remove from %collection_type%', array("%collection_type%" => collectionType($linkArtwork))), 
                array(   
                  'url'         => "@".$admin."removeFromCollection?user=".$thisUser->getUsername()."&artworkId=".$linkArtwork->getId()."&fileId=".$file->getId()."&allusers=".$sf_params->get("allusers", "false"),
                  'complete'    => "removeButtons--;Effect.BlindUp('file_".$file->getId()."');",
                  'update'      => "artwork_eligible_files",
                  'confirm'     => __("Are you sure? Note: Artworks must contain at least 1 file."),
                  'condition'   => "removeButtons > 1"),
                array("class" => "remove")); ?>
    <?php endif; ?>
    <?php include_partial("userFileInList", array("file" => $file, "thisUser" => $thisUser, "extraButton" => $extraButton)); ?>
      </li>
  <?php endforeach; ?>
</ul>
<?php echo javascript_tag("var removeButtons = countVisibleRemoveButtons();"); ?>

<?php if (isset($allowOrdering)): ?>
  <?php echo sortable_element('artwork_files', array(
    'url'    => '@artworkupdatefield?id='.$linkArtwork->getId().'&field=files',
    'loading'  => "",
    'success'  => visual_effect('highlight', 'artwork_files'),
  )); ?>
<?php endif; ?>