<?php
/**
 * User activation success, shown when a user follows the activation link in their email after registering.
 * This page will only be visible to users who provide a correct key, and are not already verified
 * Variables avalilable to this template:
 * - $newUser : The user object of the user who just activated
 * 
 * PHP Version 5
 *
 * @author    Ole-Petter <olepw@linpro.no>
 * @author    Russ <russ@linpro.no>
 * @author    Robert Strind <robert@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

reaktor::setReaktorTitle(__('Activation success - Welcome to Reaktor!')); 

?>

<h1><?php echo __("Activation successful"); ?></h1>

<div class ="page_box">
  <?php echo __("<p>Thank you, <strong>%username%</strong>!</p><p> Your account is now verified and active.</p><p>On Reaktor you can upload and present your own work,including film, photo, animation, music, comics, illustration and text. You can get feedback and tips from other users and find users that have the same interests as yourself.</p><p>You may now log in using the boxes to the right.</p><p>If you have any problems or feedback, please contact the reaktor team at the following address: %reaktor_help_email%",
                array(
                  "%username%" => $newUser->getUsername(),
                  "%reaktor_help_email%" => mail_to(
                    sfConfig::get(
                      "app_help_email",
                      "reaktor@minreaktor.no"
                    ),
                    '',
                    array("encode" => true)
                  )
                ));?>
</div>
