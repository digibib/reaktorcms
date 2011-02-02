<?php
/**
 * Password request partial to be shown when user clicks forgotten password link
 * 
 * PHP version 5
 * 
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
use_helper("Javascript", 'wai');
?>

<?php if (isset($sentOk)): ?>
	<p>
	  <?php echo __("Thank you - an email has been sent with further instructions on how to change your password.") ?>
	</p>
<?php else: ?>
	<div id="newpass_form">  
    <h4><?php echo __('Request new password') ?></h4>
    <?php echo form_remote_tag(array(
        'update'   => 'lost_pass',
        'url'      => 'profile/passwordSend',
        'loading'  => "$('email_indicator').show();$('newpass_form').hide();",
        'complete' => "$('email_indicator').hide();$('newpass_form').show();",
        'success'  => "$('toemail').value = ''"),
        array("name" => "request_pass")
      ) ?>
      <dl>
        <dt><?php echo wai_label_for('toemail', __('Please enter your email')) ?></dt>
        <dd>
          <?php echo form_error('toemail') ?>
          <?php echo input_tag('toemail') ?>
        </dd>
      </dl>
      <?php echo submit_tag(__('Request password')) ?>
    </form>
  </div>
 	<div id = "email_indicator" style = "display: none">
  	<?php echo image_tag("spinning50x50.gif") ?>
  	<?php echo __("processing..."); ?>
  </div>
<?php endif; ?>
<p style="clear: both;"><br /><?php echo link_to_function(__('Back to login'), "lostPassToggle();"); ?></p>
