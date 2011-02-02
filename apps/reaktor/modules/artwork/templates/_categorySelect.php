<?php
/**
 * Component for "main" category selection, as well as Subreaktor selection.
 * This component is used on the artwork edit page, displays a list of Subreaktors, and 
 * allows you to check/uncheck which subreaktor you want your artwork to be in. It also
 * includes the categoryList component, which lets you select categories for the artwork.
 * 
 * This component can be called with 
 * include_component("artwork", "categorySelect", array(
 *  "artwork" => $artwork));
 * 
 * Where $artwork is the artwork you want to edit.
 * 
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
use_helper("Javascript");
$warning = __("Are you sure you wish to remove this selection? All categories associated with this subReaktor will be removed automatically.");
// The javascript function and form on this page has been written manually because the Symfony form
// Handlers could not allow ajax submit via checkbox click which was needed.

?>
<?php if ($sf_user->hasCredential('editcategories') || 
         (isset($artwork) && $sf_user->getId() == $artwork->getUser()->getId())||
         (isset($article))): //Subreaktors?>
	<?php echo javascript_tag("function doSubmit() {
	   new Ajax.Updater('categorySelect', '".url_for("@category_action")."', 
	   {asynchronous:true, evalScripts:false, 
	   onComplete:function(request, json){Element.hide('cat_indicator')}, 
	   onLoading:function(request, json){Element.show('cat_indicator')}, 
	   onSuccess:function(request, json){}, 
	   parameters: $('category_form').serialize()}); 
	   return false; }"); ?>
	
	<form name = "category_form" id = "category_form" action = "">
	  <div id = "subreaktor_list">
	  	<div id = "cat_indicator" style = "display: none;">
	      <?php echo image_tag("spinning50x50.gif", array("width" => 30)); ?>
	  	</div>
	  	
	  	<h2><?php echo __("subReaktors / formats"); ?></h2>
	  	<?php if (isset($error_msg) && $error_msg== 1): ?>
	  	  <?php echo __('There must be at least one subReaktor when the article is published') ?>
	  	  <br />
	  	<?php endif ?>
	  	
	  	<?php if (count($eligibleLokalReaktors) > 0): ?>
	  	  <?php if ($sf_user->hasCredential("editusercontent") && (isset($article) ? $article->getArticleType() != ArticlePeer::HELP_ARTICLE : true)): ?>
	    	  <?php foreach($eligibleLokalReaktors as $lokalReaktorObject): ?>
	    	  <?php if ($lokalReaktorObject->getLive() != 1) continue; ?>
	    	    <?php echo checkbox_tag('subreaktorChecked[]', 
	            $lokalReaktorObject->getId(), 
	            in_array($lokalReaktorObject->getId(), 
	            $artworkSubreaktors), 
	            array("onclick" => "if(this.checked == false) {if(confirm('".$warning."')) { doSubmit(); } 
	                  else this.checked=true; } else { doSubmit();}")) ?>
	          <?php echo $lokalReaktorObject->getName(); ?> <br />
	    	  <?php endforeach; ?>
	    	<?php else: ?>
	    	   <?php foreach($eligibleLokalReaktors as $lokalReaktorObject): ?>
	    	       <?php echo input_hidden_tag("subreaktorChecked[]", $lokalReaktorObject->getId()); ?>
	    	   <?php endforeach; ?>
	    	<?php endif; ?>
	  	<?php endif; ?>
	  	
	  	<?php echo form_error('subreaktors'); ?> 
	      <?php if (count($eligibleSubreaktors) == 1): ?>
	    	  <?php $onlyReaktor = array_pop($eligibleSubreaktors); ?>  
	    	  <span style = "margin-left: 17px;font-weight:bold;"><?php echo $onlyReaktor->getName(); ?></span>
	    	  <?php echo input_hidden_tag("subreaktorChecked[]", $onlyReaktor->getId()); ?>
	    	<?php else: ?> 
	    	  <?php foreach($eligibleSubreaktors as $subreaktorObject): ?>
	    	    <?php echo checkbox_tag('subreaktorChecked[]', 
	    	      $subreaktorObject->getId(), 
	    	      in_array($subreaktorObject->getId(), 
	    	      $artworkSubreaktors), 
	    	      array("onclick" => "if(this.checked == false) {if(confirm('".$warning."')) { doSubmit(); } 
	    	            else this.checked=true; } else { doSubmit();}")) ?>
	    	    <?php echo $subreaktorObject->getName(); ?> <br />
	    	  <?php endforeach; ?> 
	    	<?php endif; ?>
	      <br />
	    	<h2><?php echo __("Categories<br /> (click to select/deselect)"); ?></h2>
	  </div>		
	  
	  <div id = "category_list">
      <?php if (isset($artwork)): ?>
	  	  <?php include_component("artwork", "categoryList", array("artwork" => $artwork)); ?>
      <?php elseif (isset($article)): ?>
        <?php include_component("artwork", "categoryList", array("article" => $article)); ?>
      <?php endif; ?>
	  </div>
	  
	  <?php if (isset($artwork)): ?>
      <?php echo input_hidden_tag("artworkId", $artwork->getId()) ?>
    <?php elseif (isset($article)): ?>
      <?php echo input_hidden_tag("articleId", $article->getId()) ?>
    <?php endif; ?>
    
	  <?php echo input_hidden_tag("subreaktorClick", true) ?>
	  <?php foreach($artworkSubreaktors as $subreaktor): ?>
	  	<?php echo input_hidden_tag("current[]", $subreaktor); ?>
	  <?php endforeach; ?>
	
	</form>
<?php else: ?>
  <h2><?php echo __("subReaktors / formats"); ?></h2>
  <?php foreach ($artworkSubreaktors as $artworkSubreaktor): ?>
    <?php echo Subreaktor::getById($artworkSubreaktor); ?><br />
  <?php endforeach; ?>
  <h2><?php echo __("Categories"); ?><br />
  <?php if ($sf_user->hasCredential('editcategories') || (isset($artwork) && $sf_user->getId() == $artwork->getUser()->getId())): ?>
    <?php echo __("(click to select/deselect)"); ?>
  <?php endif; ?>
  </h2>
  <div id = "category_list">
    <?php if (isset($artwork)): ?>
      <?php include_component("artwork", "categoryList", array("artwork" => $artwork)); ?>
    <?php elseif (isset($article)): ?>
      <?php include_component("artwork", "categoryList", array("article" => $article)); ?>
    <?php endif; ?>
  </div>
<?php endif; ?>
