<?php
/**
 * Send in-partial
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
?>
<?php if ($sf_user->hasCredential('uploadcontent') || !$sf_user->isAuthenticated()): ?>
	<div id="send_in">
	<h3><?php echo __('Send in') ?></h3>
	<p><?php echo __('In Reaktor you can publish your own artworks <b>for free</b>'); ?></p>
	<?php if ($sf_user->isAuthenticated()): ?>
	<b><?php echo reaktor_link_to(__('Upload artwork now!'), '@upload_content') ?></b>
	<?php else: ?>
	<b><?php echo reaktor_link_to(__('Register now to begin uploading your artwork!'), '@register') ?></b>
	<?php endif; ?>
	</div>
<?php endif; ?>