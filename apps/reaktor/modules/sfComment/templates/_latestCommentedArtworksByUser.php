<?php
$header = isset($header) ? $header : __("Latest commented artworks");
$comment = current($comments);
if ($comment) {
  $username = sfGuardUserPeer::retrieveByPK($comment->getArtwork()->getUserId())->getUsername();
  $slug = $username . "_latest_commented";
  include_partial('feed/rssLink', array('description' => $header, 'slug' => $slug));
}
?>
<div class="relative">
<h2><?php echo $header; ?></h2>
<?php if (count($comments)): ?>
<ul>
<?php endif; ?>
  <?php foreach ($comments as $comment): ?>
    <li>
      <?php echo reaktor_link_to($comment->getArtwork()->getTitle(), 
                                 '@show_artwork?id='.$comment->getArtwork()->getId().'&title='.$comment->getArtwork()->getTitle()) ?>
    </li>
  <?php endforeach; ?>
<?php if (count($comments)): ?>
</ul>
<?php endif; ?>
<?php if (!$comment):?>
  <?php echo __('There are no comments in this list') ?>
<?php endif ?>
</div>

