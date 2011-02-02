<?php
/**
 * User list template, used for listing users by username
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
?>
<?php include_partial('feed/rssLink', array('description' => __('users starting with %char%', array("%char%" => $startingwith)), 'slug' => 'users_by_'.$startingwith)); ?>
<h2><?php echo __('Please select a letter to list all users starting with that letter');  ?></h2>
<?php include_partial('alphaPager', array('thisPage' => $startingwith)); ?><br />
<?php if ($startingwith != ''): ?>
	<h1><?php echo __('Users starting with %letter_or_phrase%', array('%letter_or_phrase%' => '"' . $startingwith . '"')); ?></h1>
	<p><?php echo __('This is a list of all active users starting with %letter_or_phrase%, ordered alphabetically.', array('%letter_or_phrase%' => '"' . $startingwith . '"')); ?></p>
	<?php if (!empty($users)): ?>
	  <ul>
		<?php foreach ($users as $user): ?>
		  <li>
    <div style="float:left; padding-top: 3px; margin-right: 5px;">
    <?php if($user->getAvatar()): ?>
    <?php echo image_tag('/uploads/profile_images/'.$user->getAvatar(), array('size' => '48x48', 'alt' => $user->getUsername())) ?>
    <?php else: ?>
    <?php echo image_tag('/uploads/profile_images/default.gif', 'size=48x48') ?>
    <?php endif ?>
    </div>      
      <b>
      <?php if (!$user->getNamePrivate()): ?>
	      <?php echo $user->getName() . ' (' . $user->getUsername() . ')'; ?>
	    <?php else: ?>
	      <?php echo $user->getUsername(); ?>
	    <?php endif; ?></b>
      <?php if ($user->getResidence()): ?>
        <?php echo __('%username% from %residence%', array('%username%' => '', '%residence%' => $user->getResidence()->getName())) ?><br />
      <?php endif; ?>
	    <?php echo __('Registered %date%', array('%date%' => substr($user->getCreatedAt(), 0, 10))) ?><br />
      <?php echo reaktor_link_to(__('Visit this users portfolio'), '@portfolio?user='.$user->getUsername()); ?></li>
      <li><br class="clearboth" /></li>
		<?php endforeach; ?>
	  </ul>
	<?php else: ?>
	  <b><?php echo __('Sorry, could not find any users'); ?></b>
	<?php endif; ?>
<?php endif; ?>
