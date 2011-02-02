<?php
/**
 * AJAX drag and drop list to use with an artwork
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
use_helper ("content", "Javascript");

?>
<?php echo javascript_tag("
  function updateOrder()
  {
      dnd_s = document.getElementById('dnd_message_saving');
      dnd_d = document.getElementById('dnd_message_done');
      dnd_d.style.display = 'none';
      dnd_s.style.display = 'inline';
      var options = {
                      method : 'post',
                      parameters : Sortable.serialize('artwork_files'),
                      onComplete : function(request) {
                        dnd_s.style.display = 'none';
                        dnd_d.style.display = 'inline';
                      }
                    };
   
      new Ajax.Request('".url_for("@artworkupdatefield?id=".$artwork->getId()."&field=files")."', options);
  }"
);?>

<h3 style = "padding-bottom: 2px;"><?php echo __("Files in this artwork"); ?></h3> 
<?php if ($artwork->getFilesCount() == 1): ?>
  <?php echo __("Add more files to make a %collection_type%:", array("%collection_type%" => collectionType($artwork))).
                 " [ ".reaktor_link_to(__("new file"), "@artwork_link?link_artwork_id=".$artwork->getId())." / ".
                link_to(__("existing file"), "@".($sf_user->hasCredential("createcompositeartwork") ? "admin_" : "")."link_existing_file?user=".$artwork->getUser()->getUsername()."&artworkId=".$artwork->getId())." ]"; ?>
<?php else: ?>
  <?php echo __("Add more files to extend this %collection_type%:", array("%collection_type%" => collectionType($artwork))).
                " [ ".reaktor_link_to(__("new file"), "@artwork_link?link_artwork_id=".$artwork->getId())." / ".
                link_to(__("existing file"), "@".($sf_user->hasCredential("createcompositeartwork") ? "admin_" : "")."link_existing_file?user=".$artwork->getUser()->getUsername()."&artworkId=".$artwork->getId())." ]"; ?>
<?php endif; ?>
<br /><br />
<div style="float: left;">
<?php if ($artwork->getFilesCount() > 1): ?>
  <?php echo __("Drag and drop the files below to order them"); ?>
  <br /><?php echo __("The top file in this list will be the thumbnail for this artwork") ?>
<?php endif; ?>
</div>

<div style="display: none; float: right; font-weight: bold;" id="dnd_message_saving"><?php echo __("Please wait while saving the file order...")?></div>
<div style="display: none; float: right; font-weight: bold;" id="dnd_message_done"><?php echo __("File order saved!")?></div>

<ul id="artwork_files" class="sortable-list">
  <?php foreach ($artwork->getFiles() as $afile): ?>
    <?php $tags = TagPeer::getTagsByObject($afile, true); ?>
    <li id="file_<?php echo $afile->getId() ?>" >
      <div style = "float:left;">
        <?php echo image_tag(contentPath($afile, 'mini')) ?>
      </div>
      <div class="pad_for_mini">
        <p>
          <b><?php echo $afile->getTitle() ?></b>
          [ 
          <?php echo reaktor_link_to(__('edit %file%', array(' %file%' => '')), "@edit_upload?fileId=".$afile->getId())." / "; ?>
          <?php echo reaktor_link_to(__('view %file%', array(' %file%' => '')), "@show_artwork_file?id=".$artwork->getId()."&file=".$afile->getId()."&title=".$artwork->getTitle()); ?>
          <?php if ($sf_user->hasCredential("staff")): ?>
        	      <?php if ($afile->getIdentifier()!='text' && $afile->getIdentifier()!='pdf'): ?>
            <?php echo " / "; ?>
            <?php echo link_to(__('Last ned original-fil'), contentPath($afile, 'original', true)); ?>
                      <?php endif; ?>
          <?php endif; ?>
          <?php if ($artwork->getFilesCount() > 1): ?>
            <?php echo " / ".link_to_remote(__('remove %file%', array(' %file%' => '')), array(
	              'confirm' => __('Are you sure you wish to remove this file from the artwork?'),
            		'url'     => '@removefilefromartwork?artwork='.$artwork->getId().'&file='.$afile->getId(),
	              'success' => "location.reload();"
	            )); ?>
	        <?php endif; ?>
          ]
        </p>
        <p>
          <b><?php echo __("File tags: "); ?></b>&nbsp;[&nbsp;<?php echo reaktor_link_to(__('edit %file%', array(' %file%' => '')), "@edit_upload?fileId=".$afile->getId()); ?>&nbsp;]
          <?php if ($sf_user->hasCredential("editusercontent") || $sf_user->getId() == $afile->getUserId()): ?>
          	<div id="currentTags_file<?php echo $afile->getId(); ?>" class="tags_in_file_list currentTags">
              <?php include_component("tags","tagEditList", 
          	       array("taggableObject" => $afile, "options" => 
                         array("rowLimit" => 4, 
                               "completeFuncs" => $artwork->getFilesCount() > 1 ? "" : "updateArtworkTagList(".$afile->getId().",".$artwork->getId().")"))); ?>
            </div>
          <?php else: ?>
          	<?php echo implode(", ", $afile->getTags()); ?>
          <?php endif; ?>
        </p>
      </div> 
    </li>
  <?php endforeach ?>
</ul>

<?php if ($artwork->getFilesCount() > 1): ?>
  <?php echo javascript_tag(
    "Sortable.create('artwork_files', { onUpdate: updateOrder });"
  ) ?>
<?php endif; ?>
