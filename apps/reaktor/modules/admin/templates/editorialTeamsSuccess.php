<?php
/**
 * Template to show all editorial teams and their members
 *  
 * PHP version 5
 * 
 * @author    Ole-Petter Wikene <olepw@linpro.no> 
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

reaktor::setReaktorTitle(__('Editorial team settings')); 

use_helper('Javascript'); 

?>
<div class="floatleft withstripe" id="editorial_team_container" style="width: 150px;">
  <h2><?php echo __('Editorials teams') ?></h2>
  <ul>
	<?php foreach ($teams as $team): ?>
	  <li><?php echo link_to($team->getDescription(), '@listmyteams?team=' . $team->getId()); ?></li>
	<?php endforeach; ?>
  </ul>
</div>
<?php if ($members): ?>
	<div class="floatleft" style="padding: 10px;">
	<h1><?php echo $theteam->getDescription(); ?></h1>
	  <?php echo __('This is a list of all users in this editorial team.') . '<br />' . 
	  __('Remember that changing the notification setting changes it for this user in all teams<br /> - not just the current one.'); ?>
	  <?php foreach ($members as $member): ?>
        <h3><?php echo $member->getUsername() . ' (' . $member->getName() . ')'; ?></h3>
        <?php include_partial('admin/userEditorialTeam', array('user' => $member)); ?>
      <?php endforeach; ?>
  </div>
<?php endif; ?>