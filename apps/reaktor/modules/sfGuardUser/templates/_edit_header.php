<?php
/**
 * The administration backend templates for users are made by a generator. These templates can however be overridden.
 * This is a partial used in the template that displays the form, where users can be edited, but this template is also
 * used when users are created. This template is the header for the edit view of the sfGuardUser object.   
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
?>
<p>
  <?php if ($sf_user->hasCredential('edituser')) : ?>
  	&lt;&lt;<b>&nbsp;
  	    <?php echo link_to(__('Back to list of users'), '@listusers') ?>
  	</b>
  <?php endif ?>
  
  <b>&nbsp;&nbsp;
    <?php echo link_to(__('Register a new account'), '@createuser') ?>
  </b><br />
</p>