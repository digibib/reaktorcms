<?php
/**
 * User summary block, called from sidebar when a user is logged in
 *
 * Contains simple user details and user specific links, such as link
 * to edit profile.
 * 
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

?><div id="user_summary">
<h3><?php echo __('My shortcuts'); ?></h3>
<?php echo __('Logged in as %username%', array("%username%" => '<span class="fn nickname">' . $sf_user->getUsername() . '</span>')); ?>
<br />
[<?php echo reaktor_link_to(__('Log out'), '@sf_guard_signout'); ?>]
<br />
<ul class="padding_top">
  <li><?php echo reaktor_link_to(__('My page'), '@mypage?user=' . $sf_user->getUsername()); ?></li>
  <li><?php echo reaktor_link_to(__('My portfolio'), '@portfolio?user=' . $sf_user->getUsername()); ?></li>
</ul>
<ul class="padding_top">
  <li><?php echo reaktor_link_to(__('Upload artwork'), '@upload_content'); ?></li>
  <li><?php echo reaktor_link_to(__('Manage my content'), '@my_content?mode=menu'); ?></li>
</ul>
<ul class="padding_top">
  <li><?php echo reaktor_link_to(__('Edit profile'), '@profile'); ?></li>
  <li><?php echo reaktor_link_to(__('Change password'), '@changepassword?username='.$sf_user->getUsername().'&key=0'); ?></li>
</ul>
<p>
  <?php echo reaktor_link_to(__('Log out'), '@sf_guard_signout'); ?>
</p>
</div>
