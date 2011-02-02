<?php
/**
 * Component template that prints the 5 last registered users
 * Query is created and executed from profileComponents class, 
 * function executeLastUsers()
 *  
 * PHP version 5
 * 
 * @author    Ole-Petter Wikene <olepw@linpro.no>
 * @author    June Henriksen <juneih@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

?>
<?php include_partial('feed/rssLink', array('description' => __('latest registered users'), 'slug' => 'latest_users')); ?>
<div class="relative">
<ul>
<?php if (count($last) > 0): ?>
	<?php foreach ($last as $user): ?>
	  <?php $avatar_path = !is_null($user->getAvatar()) ? $user->getAvatar() : "default.gif"; ?>
	  <li>
	    <?php echo reaktor_link_to($user->getUserName(),'@portfolio?user='.$user->getUserName())  ?>
	  </li>
	<?php endforeach; ?>
<?php else: ?>
  <li><?php echo __('There are no new users in this subReaktor'); ?></li>
<?php endif; ?>
</ul>
</div>

