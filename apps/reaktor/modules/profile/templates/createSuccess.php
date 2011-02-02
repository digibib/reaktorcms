<?php
/**
 * This template assures the reader that the registration was successful.
 * It is only possible to load this page on a successful registration, it can not be accessed directly
 * Available variables:
 * - $newUser : The user object of the user that just registered
 * 
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

reaktor::setReaktorTitle(__("Registration successful")); 

?>

<h1><?php echo __("Registration successful"); ?></h1>
<div class ="page_box">
  <p><?php echo __("Welcome, <strong>%username%</strong>! You have successfully registered a new account on Reaktor.", 
                array("%username%" => $newUser->getUsername())); ?></p>
	<p><?php echo __("We have sent you an activation email to <strong>%email_address%</strong>, ", 
	              array("%email_address%" => $newUser->getEmail())); ?></p>
	<p><?php echo __("If the email address shown above is incorrect, or you have any other problems, please contact the reaktor team ", 
	              array("%reaktor_help_email%" =>  mail_to(sfConfig::get("app_help_email", "reaktor@minreaktor.no"), '', array("encode" => true)))); ?>
</div>