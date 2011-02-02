<?php
/**
 * 
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

  use_helper('content', 'wai');

  $crit = new Criteria();
  $crit->add(sfGuardUserPermissionPeer::USER_ID, $sf_guard_user->getId());
  $crit->add(sfGuardUserPermissionPeer::EXCLUDE, 0);
  $permissions = array();
  $res = sfGuardUserPermissionPeer::doSelect($crit);
  
  foreach ($res as $row)
  {
  	$permissions[] = $row->getsfGuardPermission()->getName();
  }
  // Exclude
  $crit = new Criteria();
  $crit->add(sfGuardUserPermissionPeer::USER_ID, $sf_guard_user->getId());
  $crit->add(sfGuardUserPermissionPeer::EXCLUDE, 1);
  $exclude = array();
  $res = sfGuardUserPermissionPeer::doSelect($crit);
  
  foreach ($res as $row)
  {
  	$exclude[] = $row->getsfGuardPermission()->getName();
  }
 
  
  $group_ids = array();
  foreach ($sf_guard_user->getGroups() as $aGroup)
  {
  	$group_ids[] = $aGroup->getId();
  }

  $crit = new Criteria();
  $crit->add(sfGuardGroupPermissionPeer::GROUP_ID, $group_ids, Criteria::IN);
  $res = sfGuardGroupPermissionPeer::doSelect($crit);
  
  $credentials = array();
  foreach ($res as $row)
  {
  	$credentials[] = $row->getsfGuardPermission()->getName();
  }
  $credentials = array_unique($credentials);
  
?>
<ul class="sf_admin_checklist">
<li>
  <?php echo __('Add') ?>&nbsp; 
  <?php echo __('Remove') ?>
</li>
<?php foreach (sfGuardPermissionPeer::doSelect(new Criteria()) as $aPermission): ?>
<?php $id = 'associated_permissions_' . $aPermission->getId(); ?>
<?php
$unval = $val = array();
if ($sf_request->getMethod() == sfRequest::POST):
  if ($sf_request->getParameter('unassociated_permissions['.$aPermission->getId().']')):
    $unval = array('id' => 'un' . $id);
  endif;
  if ($sf_request->getParameter('associated_permissions['.$aPermission->getId().']')):
    $val = array('id' => $id);
  endif;
else:
  if(in_array($aPermission->getName(), $exclude)):
    $unval = array('id' => 'un' .$id);
  endif;
  if(in_array($aPermission->getName(), $permissions)):
    $val = array('id' => $id);
  endif;
endif;
?>
  <li>
  <?php if (in_array($aPermission->getName(), $credentials)): ?>
    <?php echo checkbox_tag('associated_permissions['.$aPermission->getId().']', $aPermission->getId(), $val, array("onclick" => "$('un$id').checked=false;", 'title' => __('Check this box to explicitly grant this user this permission'))); ?>&nbsp;
    <?php echo checkbox_tag('unassociated_permissions['.$aPermission->getId().']', $aPermission->getId(), $unval, array("onclick" => "$('$id').checked=false;", 'title' => __('Check this box to explicitly deny this user this permission, even when inherited from another group'))); ?>
  <?php else: ?>
    <?php echo checkbox_tag('associated_permissions['.$aPermission->getId().']', $aPermission->getId(), $val, array("onclick" => "$('un$id').checked=false;", 'title' => __('Check this box to explicitly grant this user this permission'))); ?>&nbsp;
    <?php echo checkbox_tag('unassociated_permissions['.$aPermission->getId().']', $aPermission->getId(), $unval, array('disabled' => 'disabled')); ?>
  <?php endif; ?>
  &nbsp;
  <?php if (in_array($aPermission->getName(), $credentials)): ?>
    <?php echo image_tag('/images/tick.png', array('title' => __('This user inherits this permission from a group membership'), 'style' => 'height: 12px; margin-right: 4px;')); ?>
  <?php endif; ?>
  <?php echo wai_label_for('associated_permission_' . $aPermission->getId(), $aPermission->getDescription()); ?>
  </li>
<?php endforeach; ?>
</ul>
