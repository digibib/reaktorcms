<?php use_helper('Javascript'); ?>

<div id="article_artworks_container" class="article_container">
  <h2><?php echo __("Related artworks"); ?></h2>
  <ul>
    <?php foreach($files as $id => $file): ?>
    	<li id="artwork_id<?php echo $id ?>">
        <span class="thefilename"><?php echo $file->getTitle() ?></span>
        <?php echo link_to_remote(image_tag("delete.png", array("width" => "10", )), array(
            'update'   => 'article_artworks_container',
            'url'      => '@nuke_related_artwork_from_article?artwork_id='.$id. '&article_id=' . $article->getId(),
            'loading'  => "Element.show('related_artwork_delete')",
            'complete' => "setTimeout('Element.hide(\'related_artwork_delete\')', 500)",
            'confirm'  => __('Are you sure you wish to remove %artwork% from this article?', array('%artwork%' => $file->getTitle())),
          )); ?>
      </li>
    <?php endforeach; ?>
    <?php if (!$files): ?>
      <li><?php echo __("No related articles"); ?></li>
    <?php endif; ?>
  </ul>
  
  <div id="related_artwork_delete" style = "display: none;">
    <?php echo image_tag('spinning18x18.gif'); ?>
	</div>
</div>

