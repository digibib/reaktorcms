<?php
/**
 * This partial contains a (usually hidden until toggled) div containing options for editing and normalising a tag
 * Variables that should be passed:
 *  - $tag : The tag object that we want to provide editing options for
 * 
 * PHP Version 5
 *
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
?>
<?php
use_helper('wai');
?>


<div id = "tageditor_<?php echo $tag->getId(); ?>" style = "display:none;" class ="tageditor">
	<?php echo form_remote_tag(array(
        'url'      => 'tags/tagAction?mode=edittagname&tag='.$tag->getName(),
	      'confirm'  => __("All work tagged with %tag_name% will be retagged with the new tag. ".
	                       "This can be difficult to reverse if incorrect merging takes place, continue?",
	                       array("%tag_name%" => $tag->getName(),
	                             )),
        'success' => "checkNormalisationResponse(request);",
	   )); ?>
		<?php echo wai_label_for("tagname_".$tag->getId(), "*".__("Replace/merge \"%tag%\" with:", array("%tag%" => $tag->getName()))); ?>
		<?php echo input_auto_complete_tag('tags', '',
  		'tags/autocomplete',
		  array("id" => "tagname_".$tag->getId()),
		  array('use_style' => false,
            'indicator' => 'tag_indicator',
  					'frequency' => 0.5,
  					'with' => "value+'&limit=8'",
		  ));?>
		<?php echo submit_tag(__("Submit")); ?>
		<div id = "tag_indicator" style = "display: none;position: absolute;left: -20px;">
		  <?php echo image_tag('spinning18x18.gif') ?>
		</div>
		<div id="statusdiv_<?php echo $tag->getId()?>"></div>
		<p><?php echo "*".__("Enter a new or existing tag name. If you enter a new (unused) name, the tag will be renamed. If you enter an existing name, the tag will be removed and all work using this tag (%tag_name%) will be re-tagged with the supplied tag", array("%tag_name%" => $tag->getName())); ?></p>
	</form>
</div>
