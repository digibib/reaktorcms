<div id="sf_comment_list">
  <?php if (count($comments) > 0): ?>
    <?php foreach ($comments as $comment): ?>
      <?php include_partial('sfComment/commentView', array('comment' => $comment)) ?>
    <?php endforeach; ?>
  <?php else: ?>
    <p><?php __('There is no comment for the moment.') ?></p>
  <?php endif; ?>
</div>