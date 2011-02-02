<?php
/**
 * Special admin functions for users with the "adminfunctions" credential
 * 
 * PHP version 5
 * 
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
?>

<h1><?php echo __("Special admin functions"); ?></h1>

<h2><?php echo __("Cache functions"); ?></h2>
<?php if (!empty($messages)): ?>
	<p class = "message">
		<?php foreach ($messages as $message): ?>
			<?php echo $message; ?><br />
	  <?php endforeach; ?>
	</p>
<?php endif; ?>
<p>
  <?php echo __("Each time system configuration files are changed (files ending in .yml such as app.yml) the configuration cache must be cleared. ".
                 "The configuration cache was last cleared on %change_date% at %change_time%. To clear the configuration cache now, click the ".
                 "\"%button_text%\" button below.", array("%change_date%" => date("d/m/Y", $configCacheTimestamp),
                                                     "%change_time%"  => date("h:i", $configCacheTimestamp),
                                                     "%button_text%" => __("Clear configuration cache"))); ?>
</p>
<p>
	<?php echo __("Some templates are also cached to enhance the user experience. If any templates are changed, ".
	              "it is a good idea to clear the html cache by clicking the \"%button_text%\" button below.", 
	              array("%button_text%" => __("Clear html (template) cache"))); ?>
</p>
<p>
	<?php echo __("Finally there is a special memory cache which greatly speeds up processing by storing commonly accessed values (such as online user count) ".
	              "in system memory rather than accessing the database on every page load. In the unlikely event that something is changed in the admin section ".
	              "and the changes don't seem to take effect, you can try clearing the memory cache. If this fixes the problem, it should be reported as a bug.") ?>
</p>
<?php echo button_to(__("Clear configuration cache"),   "@admin_functions?mode=clearconfig"); ?>
<?php echo button_to(__("Clear html (template) cache"), "@admin_functions?mode=clearhtml"); ?>
<?php echo button_to(__("Clear memory cache"), "@admin_functions?mode=clearmemory"); ?>
<?php echo button_to(__("Clear all cached content"), "@admin_functions?mode=clearall", 
                  array("class" => "delete", "confirm" => __("Are you sure you wish to delete the entire cached content? ".
                                                             "Whilst this is a non-destructive process, the performance of the site ".
                                                             "will be affected for the first few hours of use.")
                        )); ?>