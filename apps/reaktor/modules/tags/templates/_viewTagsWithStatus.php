<?php
/**
 * Print a comma seperated list of tags with colouring to show status
 * 
 * Required parameters are detailed below:
 * - $artwork : The artwork object that we need to list the tags for              
 *
 * Variables passed back from the component
 * - $tagStatusArray : The array of tags with inside status arrays (1 is approved, 0 is not)
 * 
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
$tagsToDisplay = array();
?>
<?php foreach ($tagStatusArray as $status => $tagArray): ?>
    <?php if ($tagArray): ?>
      <?php foreach ($tagArray as $tag): ?>
	    <?php if ($status == 0): ?>
	      <?php $tagsToDisplay[] = "<span class='unapproved_tag'>".$tag."</span>"; ?>
	    <?php elseif ($status == 1): ?>
	      <?php $tagsToDisplay[] = "<span class='approved_tag'>".$tag."</span>"; ?>
	    <?php endif; ?>
	  <?php endforeach; ?>
    <?php endif; ?>
<?php endforeach; ?>

<?php if (!empty($tagsToDisplay)): ?>
	<?php echo __("Tags: %list_of_tags%", array("%list_of_tags%" => ""));?>
  <?php echo join(', ', $tagsToDisplay); ?>
<?php endif ?>

