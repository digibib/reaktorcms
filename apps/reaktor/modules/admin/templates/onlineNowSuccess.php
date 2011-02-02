<?php
/**
 * This is for test purposes so the testers can see where the online now count is being derived from
 * As such this page is unstyled, but may be expanded in future.
 * 
 * It is only available to admin users by clicking the online now link
 *
 * Variables passed from the action:
 *  - $usersOnline : The array of user objects that are contributing to the count
 * 
 * PHP Version 5
 *
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

?>
<h1><?php echo __("Users online right now"); ?></h1>
<p>
  <?php echo __("Anonymous users: %count%", array("%count%" => $anonUsers)); ?>
  <br />
  <?php echo __("Logged in users: %count%", array("%count%" => count($usersOnline))); ?>
</p>
<?php if (!empty($usersOnline)): ?>
  <table style = "width:50%">
    <tr>
      <th><?php echo ("Username"); ?></th>
      <th><?php echo ("Last login"); ?></th>
    </tr>
  <?php foreach ($usersOnline as $user): ?>
    <tr>
      <td><?php echo link_to($user->getUserName(), "@portfolio?user=".$user->getUsername()); ?></td>
      <td><?php echo $user->getLastLogin(); ?></td>
    </tr>
  <?php endforeach; ?>
  </table>
<?php else: ?>
  <?php echo __("No users online"); ?>
<?php endif; ?>