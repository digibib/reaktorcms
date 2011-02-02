<?php use_helper("content") ?>

<ul id="artworkslist">
  <?php foreach ((array)$artworks as $artwork):?>
    <li class="artwork_item">
      <div class="artwork_list_item">
      <?php echo showMiniThumb($artwork, false, false) ?><br />
      <?php $timestring = __("Upload at %timestring%", array("%timestring%" => $artwork->getCreatedAt())) ?>
      <?php echo content_tag("span", $artwork->getTitle() . '<br />' .$timestring) ?><br />
      <?php echo link_to_remote(__('Relate this artwork'), array(
         'update'   => 'relate_artwork_tag', 
         'url'      => '@relateartwork?id='.$thisArtwork->getId(). '&relate_artwork_select=' .$artwork->getId(),
         'loading'  => "Element.show('relate_artwork_ajax_indicator')",
         'complete' => "Element.hide('relate_artwork_ajax_indicator')",
         'script'   => true), array(
         'class' => 'submit'
       )); ?>
      </div>
    </li>
  <?php endforeach ?>
</ul>
<br class="clearboth" />

