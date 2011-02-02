<?php
/**
 * Wrapper for tag partials and components - just include this one to get the functionality from the tag list and new tag box.
 * The reason for this wrapper is that some of the partials that are included here are updated via ajax calls, so they are re-parsed
 * by the ajax action individually.
 * 
 * - $completeFuncs : Javascript functions to run onComplete. For example update another area of the page
 * - $thisObject    : The taggable object that these tags relate to 
 *
 * PHP Version 5
 *
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

use_helper("Javascript", "wai");
if (!isset($completeFuncs))
{
  $completeFuncs = "";
}
switch (get_class($thisObject))
{
  case "genericArtwork": $extraId = "artwork".$thisObject->getId();
  case "artworkFile"   : 
    if (isset($artworkList) && $artworkList)
    {
      $extraId = "artwork".$artworkList;
    }
    else
    {
      $extraId = "file".$thisObject->getId();
    }
  break;
  case "Article"       : $extraId = "article".$thisObject->getId();break;
  default              : $extraId = "";  break;
}
if(isset($artworkList)){
    $options = array("completeFuncs" => $completeFuncs, "artworkList" =>  $artworkList , "extraId" => $extraId);
    } 
    else
    {
    $options = array("completeFuncs" => $completeFuncs, "extraId" => $extraId);
    }
?>

<?php
echo form_remote_tag(array(
  'update'   => 'currentTags_'.$extraId,
  'url'      => 'tags/tagAction?file='.$thisObject->getId().'&mode=add&taggable='.get_class($thisObject) .'&'. http_build_query(array("options" => $options), null, "&"),
  'loading'  => "Element.show('tag_indicator')",
  'complete' => "Element.hide('tag_indicator'); ".$completeFuncs,
	'script'   => true,
  'success'  => "$('tags').value = ''",
  ),
  array("name" => "tag_form")) ?>
  <dl>
    <dt>
      <?php echo wai_label_for('tags', __('Add tag(s):')); ?>
    </dt>
    <dd>        
      <?php include_partial("tags/newTagField", array("taggableModel" => $thisObject->getTaggableModel(), "id" => $thisObject->getId())); ?>
    </dd>
    <dt>
      <?php echo wai_label_for('tag_list', __('Current tags:')); ?>
    </dt>
    <dd>
      <div id = "currentTags_<?php echo $extraId?>" class="currentTags">
        <?php include_component("tags", "tagEditList", array("taggableObject" => $thisObject, "options" => $options)); ?>
      </div>
    </dd>
  </dl>
</form>
