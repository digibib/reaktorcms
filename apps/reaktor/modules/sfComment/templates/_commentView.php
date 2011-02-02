<?php use_helper('Date'); ?>

<div class="sf_comment" id="sf_comment_<?php echo $comment['Id'] ?>">  
  
  <?php if ($sf_user->hasCredential('commentadmin')):?>
    <div id='message_<?php echo $comment['Id'];?>' class = 'message'>
      <b>
      <?php if ($comment['Unsuitable']== 1):?>      
        <?php echo __('The following comment has been flagged unsuitable:') ?>
      <?php endif ?>
      <?php if ($comment['Unsuitable']== 2):?>
        <?php echo __('This commment has been removed and is not visible to users:') ?>
      <?php endif; ?>
      </b>
    </div>
  <?php endif ?>
    
  <div class= 'comment_header'>
    <?php if (($comment['Unsuitable']== 2)&&(!$sf_user->hasCredential('commentadmin'))): ?>
      <?php echo "<span style=\"font-weight: normal; font-style: italic;\">" . __('This comment has been removed') . "</span>" ?>
    <?php else: ?>      
      <?php echo $comment['Title'] ?>
    <?php endif ?>
    <br />
  </div>
  <?php if (($comment['Unsuitable']== 2)&&(!$sf_user->hasCredential('commentadmin'))): ?>
    <?php // comment removed ?>
  <?php else: ?>
	  <p class="sf_comment_info">
	    <span class="sf_comment_author">
	      <?php echo __('Written by')." "; ?>
	      <?php if (!is_null($comment['AuthorName'])): ?>
	        <?php if (isset($comment['AuthorVisible']) && $comment['AuthorVisible']): ?>
	          <?php echo reaktor_link_to($comment['AuthorName'], '@portfolio?user=' . $comment['AuthorName']) ?>
	        <?php else: ?>
	          <?php echo $comment['AuthorName']; ?>
	        <?php endif; ?>  
	      <?php else: ?>
	        <?php
	          //ZOID: Shouldn't be in template
	          /*$user_config = sfConfig::get('app_sfPropelActAsCommentableBehaviorPlugin_user');
	          $class = $user_config['class'];
	          $toString = $user_config['toString'];
	          $peer = sprintf('%sPeer', $class);
	          $author = call_user_func(array($peer, 'retrieveByPk'), $comment['AuthorId']);
	          echo $author->$toString();*/
	        ?>
	      <?php endif; ?></span>
	    <?php echo __('%date% at %time%', array('%date%' => date('d.m.y',strtotime($comment['CreatedAt'])), '%time%' => date('H.i',strtotime($comment['CreatedAt']))));?>
	    <?php if (isset($comment["ArtworkId"])): ?>
	      <?php echo __("about artwork").": ".reaktor_link_to($comment["ArtworkTitle"], "@show_artwork?id=".$comment["ArtworkId"]."&title=".$comment["ArtworkTitle"]) ?>
	    <?php endif; ?>
	  </p>
	  <p class="sf_comment_text">
	    <?php if (($comment['Unsuitable']== 2)&&(!$sf_user->hasCredential('commentadmin'))): ?>
	      <?php echo __('This comment has been removed') ?>
	    <?php else: ?>
  	    <?php if (!(isset($comment['AuthorVisible']) && $comment['AuthorVisible'])): ?>
  	      <?php echo __('This comment is removed because its author is deleted') ?>
        <?php else: ?>
	        <?php echo nl2br($comment['Text']); ?>
	      <?php endif ?>
	    <?php endif ?>
	  </p>
  <?php endif; ?>  
</div>
