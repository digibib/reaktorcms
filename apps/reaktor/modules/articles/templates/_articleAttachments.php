<?php use_helper('Javascript'); ?>

<div id="article_attachments_container" class="article_container">
  <h2><?php echo __("Article attachments"); ?></h2>
  <?php if ($banner): ?>
    <?php echo form_tag(null, array("id" => "banner_form")); ?>
  
    <div class="attachment_message"> 
      <?php if (!$files): ?>
        <?php echo __("You must upload a banner image for this theme article"); ?>
        <p><?php echo __("Upload attachments by clicking %attachment_icon% on the editor toolbar", 
                 array("%attachment_icon%" => image_tag("/js/tiny_mce/plugins/upload/img/upload.gif"))); ?></p>

      <?php else: ?> 
        <?php echo __("Which one of these attachments do you want to use as the theme banner?"); ?>
      <?php endif; ?>
      <br />
    </div>
	  <?php echo form_error('banner_error'); ?>
	<?php endif; ?>
  <ul>
    <?php foreach($files as $id => $file): ?>
      <?php $selected = false ?>
    	<li id="id<?php echo $id ?>">
        <?php if ($banner): ?>
          <?php $selected = $banner ? $bannerid == $file->getId() : false ?>
          <?php echo radiobutton_tag("banner", $id, $selected, array("onclick" => "setBanner();")); ?>
        <?php endif; ?>
    
        <span class="thefilename"><?php echo $file ?></span>
        <?php echo link_to_remote(image_tag("delete.png", array("width" => "10", )), array(
            'update'   => 'article_attachments_container',
            'url'      => '@nuke_article_attachment?attachment_id='.$id. '&article_id=' . $article->getId(),
            'loading'  => "Element.show('attachment_delete')",
            'complete' => "setTimeout('Element.hide(\'attachment_delete\')', 500)",
            'confirm'  => __('Are you sure you wish to remove %attachment% from this article?', array('%attachment%' => $file)),
          )); ?>
        <?php if ($selected): ?>
          <?php $size = @getimagesize($file->getFullPath()); 
            if ($size && ($size[0] > 240 || $size[1] > 160)): ?>
              <?php echo content_tag("span", __("Note: As a banner this image can potentially break the layout due to its size"), 
                                     array("class" => "message")); ?>
            <?php elseif (!$size): ?>
              <?php echo content_tag("span", __("Warning: This file is not appropriate to use as a banner"), array("class" => "message")); ?>
            <?php endif; ?>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
    <?php if (!$files): ?>
      <li><?php echo __("No attachments"); ?></li>
    <?php endif; ?>
  </ul>
  
  <?php if ($banner): ?>
    </form>
  <?php endif; ?>
  
  <div id="attachment_delete" style = "display: none;">
    <?php echo image_tag('spinning18x18.gif'); ?>
	</div>
</div>

