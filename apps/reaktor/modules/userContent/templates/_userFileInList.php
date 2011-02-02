<?php
/**
 * Display a wide format single file row, for use in generic lists or info areas where file summary is required
 * This view is useful for normal users - admin users should use *** as this contains information
 * more suited to administration purposes.
 * 
 * Variables this partial requires:
 * - $file : The artwork object to show
 * 
 * PHP version 5
 * 
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

use_helper("content", "Javascript");
$title = $file->getTitle() ? $file->getTitle() : __("no title");

?>
<div class="artwork_list_image">
  <?php echo image_tag(contentPath($file, 'mini'), array(
    'title'  => $title, 
    'alt'    => $title, 
    'height' => 65, 
    'width'  => 78,
  )); ?>
</div>

<div class="artwork_list_info file_list">
  <strong><?php echo $title."</strong> [ ".reaktor_link_to(__("edit"), "@edit_upload?fileId=".$file->getId())." ]"; ?>
  <ul>
    <li id="currentTags_artwork" class="tags_in_file_list">
      <?php //The file types here are listed in the content helper so they will be translated by the automated functions ?>
      <?php echo ucfirst(__($file->getIdentifier())); ?> 
      <?php echo __("%action% on %created_date% at %created_time% by %user%", 
                  array("%created_date%" => date("d/m/Y", strtotime($file->getUploadedAt())), 
                        "%created_time%" => date("H:i", strtotime($file->getUploadedAt())),
                        "%action%" => strtolower(__("Uploaded")),
                        "%user%" => link_to($file->getUser()->getUsername(), "@portfolio?user=".$file->getUser()->getUsername()))); ?>
      <br />
      <?php /* echo __('Tags'); ?>:</b>
        <?php $taglinks = array(); ?>
        <?php foreach ($file->getTags() as $aTag): ?>
          <?php $taglinks[] = reaktor_link_to($aTag, '@findtags?tag='.$aTag); ?>
        <?php endforeach; ?>
        <?php if (!empty($taglinks)): ?>
          <?php echo join(', ', $taglinks); */?>
        <?php if ($file->getTags()): ?>
        <b><?php echo __("Tags:"); ?></b>
      <?php include_component("tags","tagEditList", 
           array("taggableObject" => $file, "options" => array("rowLimit" => 4, "nomargin" => true,'noicons' => true))); ?>
        <?php else: ?>
          <?php if ($file->getTags(true)): ?>
            <?php echo '<i style="color: #AAA;">' . __('This file has no approved tags. Tags makes your files easier to find.') . '</i>'; ?>
          <?php else: ?>
            <?php echo '<i style="color: #AAA;">' . __('This file has no tags. Tags makes your files easier to find.') . '</i>'; ?>
          <?php endif; ?>
        <?php endif; ?>
      <br />
      <?php include_partial("listArtworks", array("file" => $file)); ?>
    </li>
  </ul>
</div>
<div style = "text-align: right;">
  <?php if (sfConfig::get("admin_mode") && !$file->isHidden() && !$sf_params->get("artworkId")): ?>
    <div id = "composite_<?php echo $file->getId(); ?>" class="inline">
      <?php include_component("userContent", "artworkCompositeSelect", array("file" => $file, "thisUser" => $thisUser));  ?>
    </div>
  <?php endif; ?>
  <div class = "inline">
  	<?php if (isset($extraButton)): ?>
  		<?php echo $extraButton; ?>
  	<?php endif; ?>
    <?php if (!$file->isHidden()): ?>
      <?php echo button_to_remote(__("Remove"), array(   
    		        'success'=> "Effect.BlindUp('file_".$file->getId()."');updateContentSidebar('".$thisUser->getUsername()."');",
    		        'url' => '@hide_file?fileId='.$file->getId(),    		      
    		        'confirm' => __("You are about to completely remove this file. Any artworks that contain only this file will also be removed, are you sure?"),
    		        ), array("id" => "remove_button_".$file->getId())); ?>
    	<?php else: ?>
    		<span class = "message"><?php echo  __("This file has been removed"); ?></span>
    	<?php endif; ?>
  </div>
</div>
