<?php
/**
 * Component to display latest comments a user has written.
 * 
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1 
 */

use_helper('string');
?>
<?php
$slug = "latest_comments";
if (isset($username)):
  $slug = $username. '_' . $mode . '_comments';
endif;
?>
<?php include_partial('feed/rssLink', array('description' => isset($header) ? $header : __('latest comments'), 'slug' => $slug)); ?>
<div class="relative">
<?php if (count($comments)): ?>
  <ul>
  <?php foreach ($comments as $comment): ?>
    <li>
      <?php echo reaktor_link_to(stringCut($comment->getTitle(),20), $comment->getArtwork()->getLink()."#sf_comment_".$comment->getId())?>
    </li>
  <?php endforeach ?>
  </ul>
<?php else: ?>
  <?php echo __("There are no comments yet") ?>
<?php endif ?>
</div>
