<?php
/**
 * Display a wide format single artwork row, for use in generic lists or info areas where artwork summary is required
 * This view is useful for normal users - admin users should use displayArtworkInList.php as this contains information
 * more suited to administration purposes.
 * 
 * Variables this partial requires:
 * - $artwork  : The artwork object to show
 * - $thisUser : The current user object (if we are here as an admin user)
 * 
 * PHP version 5
 * 
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

use_helper("content", "Javascript");

?>

<div class="artwork_list_image">
  <?php echo image_tag(contentPath($artwork->getFirstFile(), 'mini'), array(
    'title'  => $artwork->getTitle(), 
    'alt'    => $artwork->getTitle(), 
    'height' => 65, 
    'width'  => 78,
  )); ?>
</div>

<div class = "artwork_list_info">
  <span>
  <strong><?php echo reaktor_link_to($artwork->getTitle(), "@show_artwork?id=".$artwork->getId()."&title=".$artwork->getTitle()); ?></strong>&nbsp;
   <b>[</b> <?php echo reaktor_link_to(__("Edit"), "@edit_artwork?id=".$artwork->getId()); ?>
    <?php if (!$artwork->isRemoved()): ?> / 
      <?php echo link_to_remote(__("Remove"), array(   
            'update'=> "artwork_".$artwork->getId(),
            'complete' => "updateContentSidebar('".$thisUser->getUsername()."');".visual_effect('highlight', 'user_artwork_list'),
            'url' => '@artwork_status_returndetails?status=5&id='.$artwork->getId(),
            'confirm' => __("You are about to completely remove this artwork, are you sure?"),
            ), array("id" => "remove_button_".$artwork->getId())); ?>
    <?php else: ?> / 
      <?php echo link_to_remote(__("Restore"), array(   
            'update'=> "artwork_".$artwork->getId(),
            'complete' => "updateContentSidebar('".$thisUser->getUsername()."');".visual_effect('highlight', 'artwork_'.$artwork->getId()),
            'url' => '@artwork_status_returndetails?status=1&id='.$artwork->getId(),
            'confirm' => __("You are about to restore this artwork to draft status, ".
                            "this will also restore any files in this artwork that were hidden. ".
                            "the user may be under the impression that these files were deleted. Are you sure?"),
            ), array("id" => "restore_button_".$artwork->getId())); ?>
    <?php endif; ?>
    <?php if ($artwork->isApproved()): ?>
      <?php echo " / ".link_to_remote(__("Disable"), array(   
            'update'=> "artwork_".$artwork->getId(),
            'complete' => "updateContentSidebar('".$thisUser->getUsername()."');".visual_effect('highlight', 'artwork_'.$artwork->getId()),
            'url' => '@artwork_status_returndetails?status=6&id='.$artwork->getId(),
            'confirm' => __("Hide this artwork temporarily?"),
            ), array("id" => "disable_button_".$artwork->getId())); ?>
    <?php elseif ($artwork->isApprovedHidden()): ?>
      <?php echo " / ".link_to_remote(__("Enable"), array(   
            'update'=> "artwork_".$artwork->getId(),
            'complete' => "updateContentSidebar('".$thisUser->getUsername()."');".visual_effect('highlight', 'artwork_'.$artwork->getId()),
            'url' => '@artwork_status_returndetails?status=3&id='.$artwork->getId(),
            'confirm' => __("Restore this artwork for public viewing?"),
            ), array("id" => "enable_button_".$artwork->getId())); ?>
    <?php endif; ?>
   
   <b>]</b>
  </span>
  <ul>
    <li id="currentTags_artwork" class="tags_in_file_list">
    <?php include sfConfig::get("sf_root_dir") . '/apps/reaktor/modules/artwork/templates/_statusRow.php'; ?>
    <?php if (!$artwork->isRemoved()): ?>
        <br />
        <?php if ($thisUser->getId() != $sf_user->getId() && $sf_user->hascredential("editusercontent")): ?>
          <?php $extra_route = "admin_"; ?>
        <?php else: ?> 
          <?php $extra_route = ""; ?>
        <?php endif; ?>
        <?php if (false && $artwork->getFilesCount() == 1): ?>
          <?php echo __("Add more files to make a %collection_type%:", array("%collection_type%" => collectionType($artwork))).
                        " ".reaktor_link_to(__("new file"), "@artwork_link?link_artwork_id=".$artwork->getId()).
                        " / ".reaktor_link_to(__("existing file"), "@".$extra_route."link_existing_file?user=".$thisUser->getUsername()."&artworkId=".$artwork->getId()); ?>
        <?php else: ?>
          <?php echo __("Add more files to extend this %collection_type%:", array("%collection_type%" => collectionType($artwork))).
                        " ".reaktor_link_to(__("new file"), "@artwork_link?link_artwork_id=".$artwork->getId()).
                        " / ".reaktor_link_to(__("existing file"), "@".$extra_route."link_existing_file?user=".$thisUser->getUsername()."&artworkId=".$artwork->getId()); ?>
        <?php endif; ?>
    <?php endif; ?>
    <br />
    <b><?php echo __("Tags:"); ?></b>
    <div class="inline_tag_list">
    <?php
    /*$tags = $artwork->getTags();
    include sfConfig::get("sf_root_dir"). '/apps/reaktor/modules/tags/templates/_viewTagsWithLinks.php'; */
    if (count($artwork->getTags(false, true)) > 0)
    {
      include_component("tags","tagEditList", 
             array("taggableObject" => $artwork, "options" => array('noicons' => true, "nomargin" => true))); 
    }
    else
    {
      if (count($artwork->getTags(false, true)) > 0)
      {
        echo '<i style="color: #AAA;">' . __('This artwork has no approved tags. Tags makes your artworks easier to find.') . '</i>';
      }
      else
      {
        echo '<i style="color: #AAA;">' . __('This artwork has no tags. Tags makes your artworks easier to find.') . '</i>';
      }
    }
    
    ?>
    </div>
    </li>
    <li>
    <?php if ($artwork->getRelatedArtworks(6, false)): ?>
      <?php echo __('This artwork is related to other artworks'); ?>
    <?php else: ?>
      <?php echo __('This artwork is not related to any other artworks'); ?>
    <?php endif; ?>
    &nbsp;[<?php echo link_to(__('Edit'), '@edit_artwork?id=' . $artwork->getId()); ?>]
    </li>
  </ul>
</div>

