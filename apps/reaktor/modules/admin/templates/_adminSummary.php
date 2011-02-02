<?php
/**
 * This component displays summary information for logged in admin users, it is currently displayed in
 * the sidebar when an admin user is logged in.
 * 
 * Variables passed from the component action
 * - $editorialteams : An array of editorial teams (as objects) that this user belongs to
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
?>
<div id="user_summary" class="admin_summary">
	<h3><?php echo __('My shortcuts'); ?></h3>
  <?php echo __('Logged in as %username%', array("%username%" => '<span class="fn nickname">' . $sf_user->getUsername() . '</span>')); ?>
	<br />
  [<?php echo reaktor_link_to(__('Log out'), '@sf_guard_signout'); ?>]
	<br />  
	<br />
	<ul class="padding_top">
	  <?php if (!sfConfig::get("admin_page")): ?>
	    <li><b><?php echo link_to(__('Admin portal'), '@admin_home'); ?></b></li>
	  <?php endif; ?>
  </ul>
  <?php if ($sf_user->hasCredential('approveartwork')): ?>
	  <ul class="padding_top">
	    <li><?php echo link_to(__('Approve artwork'), '@unapproved_listmyteams'); ?></li>
	  </ul>
  <?php endif; ?>
  <?php if ($sf_user->hasCredential('approvetags') || 
            $sf_user->hasCredential('tagadministrator') || 
            $sf_user->hasCredential('listuser')): ?>
	  <ul class="padding_top">
	    <?php if ($sf_user->hasCredential('tagadministrator')): ?>
	      <li><?php echo link_to(__('Administer tags'), '@taglist'); ?></li>
	    <?php endif; ?>
	    <?php if ($sf_user->hasCredential('listuser')): ?>
	      <li><?php echo link_to(__('Administer users'), '@listusers'); ?></li>
	    <?php endif; ?>
	  </ul>
	<?php endif; ?>
  <ul class="padding_top">
    <?php if ($sf_user->hasCredential('viewallcontent')): ?>
      <li><?php echo link_to(__('Content under discussion'), '@listdiscussion'); ?></li>
    <?php endif; ?>
    <?php $perm = ArticlePeer::getArticleTypesByPermission($sf_user);
    if (count($perm)):?>
      <li><?php echo link_to(__('Compose article'), '@createarticle'); ?></li>
    <?php endif; ?>
  </ul>
  <ul class="padding_top">
    <li><?php echo reaktor_link_to(__('My page'), '@mypage?user=' . $sf_user->getUsername()); ?></li>
    <li><?php echo reaktor_link_to(__('Edit profile'), '@profile'); ?></li>
    <li><?php echo reaktor_link_to(__('Change password'), '@changepassword?username='.$sf_user->getUsername().'&key=0'); ?></li>
  </ul>
  <ul class="padding_top">
    <li><?php echo reaktor_link_to(__('Log out'), '@sf_guard_signout'); ?></li>
	</ul>
</div>
