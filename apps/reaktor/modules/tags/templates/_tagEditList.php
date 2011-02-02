<?php
/**
 * Tag edit list component, used to display a list of tags with editing features appropriate to user priveledges.
 * It is used when adding/removing tags from objects (files, artworks etc) but also when editing tags in general
 * (for example as an administrator approving tags). For this reason there are a few combinations of parameters which can be sent
 * to this component, with differing results.
 * - $tagObject      : The object that has been tagged - actions carried out on this page will reflect on this object (artwork/article etc)
 * - $tags           : The tag objects that we are listing - they could have come from the object (above) or from a generic list
 * - $unapproved     : Used by the component. Set true to return only unapproved tags in the response.
 * - $taglength_error: Returned by the ajax action - set if we need to display a message to the user.
 * - $page           : Returned by the ajax action - the current page we are viewing (possibly redundant now)
 * - $options        : An array of options to send to the component, the following are available:
 * - $noicons        : Whether to show icons next to tags (effectively turns the list into a red/green list)
 * - 	rowLimit       : If set will insert a <br /> tag every time this limit is reached when listing tags
 * -  artworkList    : Tells the component that this is an artwork list, overrides the use of extra file id
 * -  nomargin       : If set removes the left margin from the ul element
 * -  extraId        : File id or artwork id that will be appended
 * -  tageditor      : True or false, includes a tag editor partial to handle normalisation - should only be used on vertical lists
 * -  completeFuncs  : Javascript functions to be called when ajax requests have completed, seperate with semi-colon.
 * -  commas         : Show commas next to tags in list view
 * 
 * This template may be rendered by a calling (parent) template or an ajax call.
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

$tagList     = "";
$notTheFirst = false;
use_helper("Javascript");

$objectId            = isset($objectId) ? $objectId : 0;
$taggable            = isset($taggable) ? $taggable : 0;
$tagCount            = 0;
$unapprovedTagsExist = array();

$DEFAULT_OPTIONS = array(
  "rowLimit"    => 0,
  "artworkList" => false,
  "nomargin"    =>  false,
  "extraId"     => "",
  "completeFuncs" => "",
  "tageditor"    => false,
  "commas"       => false,
);
if (isset($options) && !empty($options))
{
  $options = $options + $DEFAULT_OPTIONS;
}
else
{
  $options = $DEFAULT_OPTIONS;
}

?>
<?php if (isset($tag_error)): ?>
  <?php echo javascript_tag("alert('".$tag_error."');"); ?>
<?php endif; ?>
<?php if ($tags): ?>
  <ul <?php echo $options["nomargin"] ? "style='margin-left:0px'" : ""; ?>>
    <?php $tagcc = 0; ?>
    <?php foreach ($tags as $tagObject):?>
      <li>
        <span class = "tag_container">
          <?php if (!isset($options['noicons']) || !$options['noicons']): ?>
            <?php if ($sf_user->hasCredential("approvetags") && $tagObject->getApproved() == 0): ?>
              <?php echo link_to_remote(image_tag("ok.gif", array("width" => "10")), array(
                'update'   => 'currentTags'.$options["extraId"],
              	'url'      => 'tags/tagAction',
                'script'  => true,
              	'with'     => "'".http_build_query(array("options" => $options))."&file=".$objectId."&taggable=".$taggable."&tag=".$tagObject->getName()."&mode=approve&page=".$sf_params->get("page")."&unapproved=".$sf_params->get("unapproved")."'",
              	'loading'  => "Element.show('tag_indicator')",
              	'complete' => "setTimeout('Element.hide(\'tag_indicator\')', 500);".($options["completeFuncs"]),
                'confirm'  => __('Are you sure you wish to approve the tag: %1% ?', array('%1%' => $tagObject->getName()))
              ));
              $unapprovedTags[] = $tagObject->getName();
            ?>
            <?php endif; ?>
            <?php if ($sf_user->hasCredential("tagadministrator") && ($tagObject->getApproved() == 1 || $sf_params->get("page"))): ?>
              <?php $class = ($objectId == 0 && $tagObject->getApproved()) ? "indent" : ""; ?> 
              <?php echo link_to_remote(image_tag("delete.gif", array("width" => "10", "class" => $class)), array(
                'update'   => 'currentTags'.$options["extraId"],
              	'url'      => 'tags/tagAction',
                'script'  => true,
              	'with'     => "'".http_build_query(array("options" => $options))."&file=".$objectId."&taggable=".$taggable."&tag=".$tagObject->getName()."&mode=unapprove&page=".$sf_params->get("page")."&unapproved=".$sf_params->get("unapproved")."'",
              	'loading'  => "Element.show('tag_indicator')",
              	'complete' => "setTimeout('Element.hide(\'tag_indicator\')', 500);".($options["completeFuncs"]),
                'confirm'  => __('Are you sure you wish to unapprove and completely remove this tag (%1%) from the system? This will affect all other tagged objects using this tag.', array('%1%'=> $tagObject->getName()))
              )); ?>
            <?php endif; ?>
            <?php if ($objectId > 0): ?> 
              <?php $class = (!$sf_user->hasCredential("tagadministrator")) ? "indent" : "" ?>
              <?php if (strtolower($taggable) == 'genericartwork'): ?>
                <?php $confirm_string = __('Are you sure you wish to remove the tag: %1% from this artwork?', array('%1%' => $tagObject->getName())); ?>
              <?php else:?>
                <?php $confirm_string = __('Are you sure you wish to remove the tag: %1% from this file?', array('%1%' => $tagObject->getName())); ?>
              <?php endif;?>
              <?php echo link_to_remote(image_tag("delete.png", array("width" => "10", "class" => $class)), array(
                  'update'   => 'currentTags'.$options["extraId"],
                	'url'      => 'tags/tagAction',
                    'script'  => true,
                	'with'     => "'".http_build_query(array("options" => $options))."&file=".$objectId."&taggable=".$taggable."&tag=".$tagObject->getName()."&mode=delete&page=".$sf_params->get("page")."&unapproved=".$sf_params->get("unapproved")."'",
                	'loading'  => "Element.show('tag_indicator')",
                	'complete' => "setTimeout('Element.hide(\'tag_indicator\')', 500);".($options["completeFuncs"]),
                	'confirm'  => $confirm_string
              )); ?>
            <?php endif; ?>
            <?php if ($options["tageditor"] && $sf_user->hasCredential("tagadministrator")): ?>
            	<?php echo link_to_function(image_tag("/sf/sf_admin/images/edit_icon.png", array("width" => 10)), 
            	              "Effect.toggle('tageditor_".$tagObject->getId()."', 'slide')"); ?>
            <?php endif; ?>
          <?php endif; ?>
          <span class = '<?php echo $tagObject->getApproved() == 1 ? 'approved_tag' : 'unapproved_tag'; ?>'>
            <?php if($objectId == 0): ?>
              <?php echo link_to($tagObject->getName(), "@findtags?tag=".$tagObject->getName()); ?>
            <?php else: ?>
              <?php echo $tagObject->getName(); ?>
            <?php endif; ?>
          </span>
        </span>
      <?php if ($options["tageditor"] && $sf_user->hasCredential("tagadministrator")): ?>
      	<?php include_partial("tageditor", array("tag" => $tagObject)); ?>
      <?php endif; ?>
      <?php if (isset($options['commas']) && $options['commas'] && (!isset($options['noicons']) || $options['noicons']) && $tagcc > 0 && $tagcc < (count($tags) - 1)) echo ', '; ?>
      </li>
      <?php if ($options["rowLimit"] > 0 && ++$tagCount % $options["rowLimit"] == 0): ?>
      	<br />
      <?php endif; ?>
      <?php $tagcc++; ?>
    <?php endforeach; ?>
  </ul>
  <?php if  (!empty($unapprovedTags) && $sf_user->hasCredential("approvetags")): ?>
  	<?php $tiptext = "<div style=\'width:200px;\'>".__("These actions apply to unapproved tags only, you can quickly approve or remove all the red tags by clicking one of these icons")."</div>"; ?>
    <div id ="all_tag_actions<?php echo $options["extraId"]; ?>" class="all_tag_actions">
      <?php echo __("All: %tag_option_icons%", array("%tag_option_icons%" => "")); ?>
      <?php echo link_to_remote(image_tag("ok.gif", array("width" => "10")), array(
            'update'   => 'currentTags'.$options["extraId"],
          	'url'      => 'tags/tagAction',
          	'with'     => "'".http_build_query(array("options" => $options, "unapprovedTags" => $unapprovedTags))."&file=".$objectId."&taggable=".$taggable."&tag=".$tagObject->getName()."&mode=approveall&page=".$sf_params->get("page")."&unapproved=".$sf_params->get("unapproved")."'",
          	'loading'  => "Element.show('tag_indicator')",
          	'complete' => "setTimeout('Element.hide(\'tag_indicator\')', 500);".($options["completeFuncs"]),
          	'confirm'  => __('Are you sure you wish to APPROVE all of the following tags? %tag_list%', array("%tag_list%" => "\\n\\n".implode(", ", $unapprovedTags))),
          ), array("onMouseover" => "Tip('".$tiptext."');", "onMouseout" => "UnTip();")); ?>
      <?php if ($objectId > 0): ?>
        <?php echo link_to_remote(image_tag("delete.png", array("width" => "10")), array(
              'update'   => 'currentTags'.$options["extraId"],
            	'url'      => 'tags/tagAction',
            	'with'     => "'".http_build_query(array("options" => $options, "unapprovedTags" => $unapprovedTags))."&file=".$objectId."&taggable=".$taggable."&tag=".$tagObject->getName()."&mode=deleteall&page=".$sf_params->get("page")."&unapproved=".$sf_params->get("unapproved")."'",
            	'loading'  => "Element.show('tag_indicator')",
            	'complete' => "setTimeout('Element.hide(\'tag_indicator\')', 500);".($options["completeFuncs"]),
            	'confirm'  => __('Are you sure you wish to REMOVE all of the following tags from this work? %tag_list%', array("%tag_list%" => "\\n\\n".implode(", ", $unapprovedTags))),
            ), array("onMouseover" => "Tip('".$tiptext."');", "onMouseout" => "UnTip();")); ?>
      <?php endif; ?>
      <?php if ($sf_user->hasCredential("tagadministrator")): ?>
        <?php echo link_to_remote(image_tag("delete.gif", array("width" => "10")), array(
            'update'   => 'currentTags'.$options["extraId"],
          	'url'      => 'tags/tagAction',
          	'with'     => "'".http_build_query(array("options" => $options, "unapprovedTags" => $unapprovedTags))."&file=".$objectId."&taggable=".$taggable."&tag=".$tagObject->getName()."&mode=unapproveall&page=".$sf_params->get("page")."&unapproved=".$sf_params->get("unapproved")."'",
          	'loading'  => "Element.show('tag_indicator')",
          	'complete' => "setTimeout('Element.hide(\'tag_indicator\')', 500);".($options["completeFuncs"]),
          	'confirm'  => __('Are you sure you wish to DELETE all of the following tags from the system? %tag_list%', array("%tag_list%" => "\\n\\n".implode(", ", $unapprovedTags))),
          ), array("onMouseover" => "Tip('".$tiptext."');", "onMouseout" => "UnTip();")); ?>
      <?php endif; ?>
    </div>
  <?php endif; ?>
<?php elseif (!$sf_params->get("page")): ?>    
  <?php include_partial("tags/tagWarningMessage", array("object" => $taggableObject, "options" => $options)); ?>
<?php else: ?>
  <div id = 'tag_warning'>
    <ul>
      <li class = 'spaced'><?php echo __('No results');?></li>
    </ul>
  </div>
<?php endif; ?>
<div id = "tag_indicator" style = "display: none;">
  <?php echo image_tag('spinning18x18.gif') ?>
</div>
