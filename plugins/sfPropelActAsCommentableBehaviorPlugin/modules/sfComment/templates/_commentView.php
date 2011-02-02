<?php use_helper('Date'); ?>
<div class="sf_comment" id="sf_comment_<?php echo $comment['Id'] ?>">
  <p class="sf_comment_info">
    <span class="sf_comment_author">
      <?php if (!is_null($comment['AuthorId'])): ?>
        <?php
        $user_config = sfConfig::get('app_sfPropelActAsCommentableBehaviorPlugin_user');
        $class = $user_config['class'];
        $toString = $user_config['toString'];
        $peer = sprintf('%sPeer', $class);
        $author = call_user_func(array($peer, 'retrieveByPk'), $comment['AuthorId']);
        echo $author->$toString();
        ?><?php else: ?><?php echo $comment['AuthorName'] ?><?php endif; ?></span>,
    <?php echo __('%1% ago', array('%1%' => distance_of_time_in_words(strtotime($comment['CreatedAt'])))) ?>
  </p>
  <p class="sf_comment_text">
    <?php echo $comment['Text']; ?>
  </p>
</div>