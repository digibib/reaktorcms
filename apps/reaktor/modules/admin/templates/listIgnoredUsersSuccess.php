<?php
/**
 * Lists the users that are ignored often
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

reaktor::setReaktorTitle(__('List ignored users')); 

use_helper('wai');
?>

<h1><?php echo __('List of ignored users') ?></h1>
<?php echo form_tag('@listignoredusers') ?>
<?php echo wai_label_for('min_count', __('Ignored by min # users')) ?>
<?php echo input_tag('min_count', $countlimit, array('size' => 3, 'length' => 3)) ?>
<?php echo submit_tag(__('Find')) ?>
<?php echo '</form>'; ?>
<?php if (count($users) == 0): ?>
  <tr><td colspan=3><?php echo __('There are no users in this list') ?></td></tr>
<?php else: ?>
	<table>
	<thead>
	<tr>
	  <th><?php echo __('User') ?></th>
	  <th><?php echo __('Ignored by') ?></th>
	  <th><?php echo __('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($users as $a_user): ?>
		<tr>
		  <td style="padding-right: 10px;"><?php echo $a_user['username'] ?> (<?php echo $a_user['realname'] ?>)</td>
		  <td style="padding-right: 10px;"><?php echo __('%1% users', array('%1%' => $a_user['count'])) ?></td>
		  <td><?php echo link_to(__('View portfolio'), '@portfolio?user='.$a_user['username']) ?> | 
		  <?php echo link_to(__('Edit user'), '@edituser?id='.$a_user['id']) ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
<?php endif; ?>
