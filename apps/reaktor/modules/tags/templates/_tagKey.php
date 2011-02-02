<?php
/**
 * A key to the symbols used in tag administration
 * 
 * Displayed in the filter box on the tag list/administration page
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

?>

<h2><?php echo __("Key to symbols"); ?></h2>
<br />
<ul>
	<li>
	  <?php echo image_tag("delete.gif"); ?>
	  <?php echo __("Remove the tag completely"); ?>
	</li>
	<li>
		<?php echo image_tag("ok.gif"); ?>
	  <?php echo __("Approve the tag"); ?>
	</li>
	<li>
	  <?php echo image_tag("/sf/sf_admin/images/edit_icon.png", array("width" => 10)); ?>
	  <?php echo __("Edit/normalise the tag"); ?>
	</li>
</ul>