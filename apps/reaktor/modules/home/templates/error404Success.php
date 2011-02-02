<?php
/**
 * Custom error 404 page
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

reaktor::setReaktorTitle(__('Not found')); 

?>

<div id = "error404">
	<p><?php echo __("Sorry, the page or content that you have requested does not exist").", "; ?>
	<?php echo __("or you do not have the required permissions to access this content.") ?></p>
	<p><?php echo __("If you feel there has been an error, please contact us at...") ?></p>
</div>