<?php
/**
 * change password
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

reaktor::setReaktorTitle(__('Change password')); 

?>

<?php if (!$verified): ?>
  <div id="update_password">
<?php endif; ?>
<?php use_helper('Javascript', 'wai') ?>
<?php if ($error != ''): ?>
  <?php echo $error; ?>
<?php else: ?>
  <?php if (!$verified && !$forgot): ?>
	  <h2><?php echo __('Change password for %username%', array('%username%' => $user->getUsername())) ?></h2>
	  <?php echo form_remote_tag(array(
	      'update'   => 'update_password',
	      'url'      => '@changepassword?username='.$user->getUsername().'&key='.$key),
	      array("name" => "verify_info")
	    ) ?>
	    <?php echo input_hidden_tag('verify', true) ?>
      <?php echo wai_label_for('current_pass', __('Current password')) ?>
      <?php echo input_password_tag('current_pass') ?>
	    <?php echo submit_tag(__('Verify')) ?>
	  <?php echo '</form>'; ?>
    <?php echo $verifyerror ?>
  <?php elseif (!$passwordupdated): ?>
    <?php if ($verified): ?>
      <h3>Thank you!</h3>
    <?php else: ?>
      <h2><?php echo __('Change password for %username%', array('%username%' => $user->getUsername())) ?></h2>
    <?php endif; ?>
      <?php echo __('Please enter your new password twice, then press the "Change password" button to change it') ?><br />
      <br />
      <?php echo form_remote_tag(array(
          'update'   => 'update_password',
          'url'      => '@changepassword?username='.$user->getUsername().'&key='.$key),
          array("name" => "update_password_form")
        ) ?>
      <?php echo input_hidden_tag('verify', true) ?>
      <?php echo input_hidden_tag('updatepassword', true) ?>
	      <?php if ($key != 0): ?>
		      <?php echo input_hidden_tag('dob[day]', $dob['day']) ?>
		      <?php echo input_hidden_tag('dob[month]', $dob['month']) ?>
		      <?php echo input_hidden_tag('dob[year]', $dob['year']) ?>
	      <?php endif; ?>
        <?php echo wai_label_for('new_password1', __('New password')) ?><br />
        <?php echo input_password_tag('new_password1') ?><br />
        <?php echo wai_label_for('new_password2', __('Repeat password')) ?><br />
        <?php echo input_password_tag('new_password2') ?><br />
      <?php echo submit_tag('Change password') ?>
    <?php echo '</form>'; ?>
    <?php if ($passworderror): ?>
      <br />
      <?php echo __('Please enter the new password twice') ?>
    <?php endif; ?>
  <?php else: ?>
    <h3><?php echo __('Your password has been changed') ?></h3>
    <?php if ($key != 0): ?>
      <?php echo __('You can now log in using the form to the right') ?>
    <?php endif; ?>
  <?php endif; ?>
<?php endif; ?>
<?php if (!$verified): ?>
  </div>
<?php endif; ?>

