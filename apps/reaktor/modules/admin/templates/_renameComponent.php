<?php
/**
 * This partial contains a (usually hidden until toggled) div containing options for editing and normalising a category
 * Variables that should be passed:
 *  - $category : The tag object that we want to provide editing options for
 * 
 * PHP Version 5
 *
 * @author    Ole-Petter <olepw@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
?>
<?php
use_helper('wai');
?>


<div id = "categoryeditor_<?php echo $category->getId(); ?>" style = "display:none;" class ="tageditor">
	<?php echo form_remote_tag(array(
        'url'      => '@renameCategory?id='.$category->getId()."&basename=".$category->getBasename(),
	      'confirm'  => __("All work tagged with %tag_name% will be retagged with the new tag. ".
	                       "This can be difficult to reverse if incorrect merging takes place, continue?",
	                       array("%tag_name%" => $category->getName(),
	                             )),
        'success' => "checkNormalisationResponse(request);",
	    'update' => "statusdiv_".$category->getId(),
	   )); ?>
		<?php echo wai_label_for("category_".$category->getId(), "*".__("Replace/merge \"%tag%\" with:", array("%tag%" => $category->getName()))); ?>
		<?php echo input_auto_complete_tag('new_cat', '',
  		'category/autocomplete',
		  array("id" => "category_".$category->getId()),
		  array('use_style' => false,
                    'indicator' => 'tag_indicator',
  					'frequency' => 0.5,
  					'with' => "value+'&limit=8'",
		  ));?>
		<?php echo submit_tag(__("Submit")); ?>
		<div id = "tag_indicator" style = "display: none;position: absolute;left: -20px;">
		  <?php echo image_tag('spinning18x18.gif') ?>
		</div>
		<div id="statusdiv_<?php echo $category->getId()?>"></div>
		<p><?php echo "*".__("Enter a new or existing tag name. If you enter a new (unused) name, the tag will be renamed. ".
		                     "If you enter an existing name, the tag will be removed and all work using this tag (%tag_name%) will be re-tagged ". 
		                     "with the supplied tag", array("%tag_name%" => $category->getName())); ?></p>
	</form>
</div>
