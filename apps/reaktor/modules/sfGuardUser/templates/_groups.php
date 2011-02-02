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

  if (!function_exists("tmp_getTip"))
  {
  function tmp_getTip($aGroup)
  {
    $mouseOver = 'Tip(\'<div class="tool_tip_internal">';
    $mouseOver .= '<p>' . __('By selecting this user group/editorial team, the user <br />will automatically get the permissions listed below') . '</p>';
    $mouseOver .= '<p><b>' . __('Permissions in this user group/editorial team') . '</b></p>';
    
    $mouseOver .= '<ul class="group_permissions_list_tip">';
    foreach ($aGroup->getsfGuardGroupPermissions() as $aGroupPermission)
    {
      $mouseOver .= '<li class="check">' . str_replace('\'', '"', $aGroupPermission->getsfGuardPermission()->getDescription()) . '</li>';
    }
    if (count($aGroup->getsfGuardGroupPermissions()) == 0)
    {
    	$mouseOver .= '<li>' . __('This user group/editorial team has no specific permissions set') . '</li>';
    }
    $mouseOver .= '</ul>';
    $mouseOver .= '\')';
    return $mouseOver;
  }
  }
  
?>
<p><b><?php echo __('User groups'); ?></b></p>
<ul class="sf_admin_checklist">
<?php foreach (sfGuardGroupPeer::getUserGroups() as $aGroup): ?>
  <?php $mouseOver = tmp_getTip($aGroup); ?>
  <li class="tip_item">
  <?php echo checkbox_tag('associated_groups['.$aGroup->getId().']', $aGroup->getId(), (($sf_request->getMethod() == sfRequest::POST && $sf_request->getParameter('associated_groups['.$aGroup->getId().']')) || ($sf_request->getMethod() != sfRequest::POST && $sf_guard_user->hasGroup($aGroup->getName()))), array('id' => 'associated_groups_' . $aGroup->getId())); ?>
  <?php echo wai_label_for('associated_groups_' . $aGroup->getId(), $aGroup->getDescription(), array('onMouseOver' => $mouseOver, 'onMouseOut' => 'UnTip()')); ?>
  [ <?php echo link_to(__('Edit'), '@editgroup?id=' . $aGroup->getId(), array('target' => '_new')); ?> ]
  </li>
<?php endforeach; ?>
</ul>
<br />
<p><b><?php echo __('Editorial teams'); ?></b></p>
<ul class="sf_admin_checklist">
<?php foreach (sfGuardGroupPeer::getEditorialTeams() as $aTeam): ?>
  <?php $mouseOver = tmp_getTip($aTeam); ?>
  <li class="tip_item">
  <?php echo checkbox_tag('associated_groups['.$aTeam->getId().']', $aTeam->getId(), (($sf_request->getMethod() == sfRequest::POST && $sf_request->getParameter('associated_groups['.$aTeam->getId().']')) || ($sf_request->getMethod() != sfRequest::POST && $sf_guard_user->hasGroup($aTeam->getName()))), array('id' => 'associated_groups_' . $aTeam->getId())); ?>
  <?php echo wai_label_for('associated_groups_' . $aTeam->getId(), $aTeam->getDescription(), array('onMouseOver' => $mouseOver, 'onMouseOut' => 'UnTip()')); ?>
  [ <?php echo link_to(__('Edit'), '@editgroup?id=' . $aTeam->getId(), array('target' => '_new')); ?> ]
  </li>
<?php endforeach; ?>
</ul>
