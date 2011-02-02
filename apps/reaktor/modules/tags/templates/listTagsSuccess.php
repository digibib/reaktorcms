<?php
/**
 * List all the tags for administration purposes
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

reaktor::setReaktorTitle(__("Tags (%tag_letter%)", array("%tag_letter%" => $page)));

?>
<br />
<?php include_partial('alphaPager',array('letters' => $pageLinks, 'thisPage'=>$page)); ?>
<h1>
  <?php echo __("All")." "; ?>
  
  <?php if ($sf_params->get("unapproved")): ?>
    <?php echo __("unapproved tags")." "; ?>
  <?php elseif (!$sf_params->get("unapproved")): ?>
    <?php echo __("tags"); ?> 
  <?endif; ?>
  
  <?php if ($page != "ALL"): ?>  
    <?php echo __("starting with")." '".$page."'"; ?> 
  <?php endif; ?>
</h1> 

<br />

<div id ="currentTags" class = "longer currentTags">
  <?php include_partial("tags/tagEditList", 
        array("tags" => $tags, "unapproved" => $sf_params->get("unapproved"), "options" => array("tageditor" => true))); ?>
</div>

<div id = "tag_key">
	<h2><?php echo __("Filters") ?></h2>
	<br />
	<ul>
		<li>
    	<?php if ($sf_params->get("unapproved")): ?>
        <?php echo link_to(image_tag("magnifier_zoom_in.png"), "@taglist?page=".$page); ?>
        <?php echo __("Show approved and unapproved tags") ?>
      <?php else: ?>
        <?php echo link_to(image_tag("magnifier_zoom_out.png"), "@taglist_unapproved?page=".$page); ?>
        <?php echo __("Show only unapproved tags") ?>
      <?endif; ?>
    </li>
  </ul>
    <?php include_partial("tags/tagKey"); ?>
    <?php include_partial("tags/addTag"); ?>
</div>
