<?php use_helper("content") ?>

<ul id="artworkslist">
  <?php foreach ($artworks as $artwork):?>
    <li class="artwork_item">
      <div class="artwork_list_item">
      <?php echo showMiniThumb($artwork, false, true) ?><br />
      <?php echo content_tag("span", $artwork->getTitle()) ?><br />
      <?php echo content_tag("a", __("Embed this artwork"), array("onclick" => "ArtworklistDialog.insert('".$artwork->getId()."')", "href" => "")) ?><br />
      <?php echo link_to_remote(__('Relate this artwork'), array(
                  'url' => '@relateartworktoarticle?article_id='.$article->getId().'&artwork_id='.$artwork->getId(),
                  'complete' => 'tinyMCEPopup.getWin().updateArtworks();setTimeout("tinyMCEPopup.close()", 1000);'));
      ?>
      </div>
    </li>
  <?php endforeach ?>
</ul>
<br style="clear: both" /><br />

