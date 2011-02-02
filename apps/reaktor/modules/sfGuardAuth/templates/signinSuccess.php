<?php
/**
 * Shows message to non-authed user
 * 
 * This template replaces the sfGuardAuth standard template for the login form
 * It is shown when a user attempts to access a restricted page before logging in
 * 
 * The login box follows the user on the sidebar, so there is no need to repeat it
 * here, we will simply inform the user that they must login or register.
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
?>
<div id = "secure_notice">
<?php if ($sf_params->get('username')): ?>
	<p><?php echo __('There was an error with your login, please check your details and try again.')?></p>	
<?php else: ?>
	<p><?php echo __('You need to log in to view this page, please use the login form to the right.')?></p>
<?php endif; ?>
<p><?php echo __('If you do not have a Reaktor account, please').' '.link_to(__('Register'), '@register'); ?></p>
</div>