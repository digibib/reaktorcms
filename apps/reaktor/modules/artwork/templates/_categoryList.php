<?php
/**
 * Component for "main" category selection
 * 
 * This component is used on the artwork edit page, and shows you a list of available categories,
 * which you can click to select. Selected categories are marked with green, bold text.
 * 
 * If you are not allowed to edit the information, the artworks categories are just listed.
 * 
 * Include the component like this:
 * include_component("artwork", "categoryList", array(
 *  "artwork" => $artwork));
 * 
 * Takes an $artwork as a parameter, and that's all it needs. 
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
use_helper("Javascript");
?>
<?php if ($sf_user->hasCredential('editcategories') || 
         (isset($artwork) && $sf_user->getId() == $artwork->getUser()->getId()) ||
         (isset($article))): ?>
	<?php echo form_error('categories'); ?> 
	<?php $seperator = ""; ?>
	<?php if (empty($eligibleCategories)): ?>
    <?php if (isset($artwork)): ?>
      <p class="warning_box">
	      <?php echo __("Please select one or more subReaktors by checking the boxes above."); ?>
		    <?php echo __("You must select at least one category which defines your content (photo/film/etc)."); ?>
      </p>
    <?php elseif (isset($article)): ?>
      <p>
        <?php echo __("If you want this article to appear in a subReaktor, check the boxes above."); ?>
        <?php echo __("You can also select a category to make it appear in category search."); ?>
      </p>
    <?php endif; ?>
	<?php else: ?> 
		<ul id = "category_tag_list">
	  <?php foreach ($eligibleCategories as $categoryId => $category):?>
		  <?php if (in_array($categoryId, $artworkCategories)): ?>
				<?php $toggle = "remove"; ?>
				<li class = "category_selected">
		  <?php else: ?>
		  	<?php $toggle = "add"; ?>
		  	<li>
		  <?php endif; ?> 
		  <?php echo $seperator ?>
      <?php if (isset($artwork)): ?>
			  <?php echo link_to_remote($category, array(
		      'update'   => 'category_list',
		    	'url'      => '@category_action',
		    	'with'     => "'artworkId=".$artwork->getId()."&".$toggle."=".$categoryId."'",
			    'loading'  => "Element.show('cat_indicator')",
		      'complete' => "setTimeout('Element.hide(\'cat_indicator\')', 500)"
		      )); ?>
      <?php elseif (isset($article)): ?>
        <?php echo link_to_remote($category, array(
          'update'   => 'category_list',
          'url'      => '@category_action',
          'with'     => "'articleId=".$article->getId()."&".$toggle."=".$categoryId."'",
          'loading'  => "Element.show('cat_indicator')",
          'complete' => "setTimeout('Element.hide(\'cat_indicator\')', 500)"
          )); ?>      
      <?php endif; ?>
		  <?php $seperator = " "; ?>
		  </li> 
		<?php endforeach; ?>  
		</ul>	
	<?php endif; ?>
	<?php foreach ($otherCategories as $categoryId => $category):?>
	  <?php if (in_array($category, $artworkCategories)): ?>
	    <?php $toggle = "remove"; ?>
	    <span class = "category_selected">
	  <?php else: ?>
	    <?php $toggle = "add"; ?>
	    <span>
	  <?php endif; ?> 
	  <?php echo $seperator ?>
    <?php if (isset($artwork)): ?>
		  <?php echo link_to_remote($category, array(
		    'update'   => 'category_list',
		    'url'      => '@category_action',
		    'with'     => "'artworkId=".$artwork->getId()."&".$toggle."=".$categoryId."'",
		    'loading'  => "Element.show('cat_indicator')",
		    'complete' => "setTimeout('Element.hide(\'cat_indicator\')', 500)"
		    )); ?>
    <?php elseif (isset($article)): ?>
      <?php echo link_to_remote($category, array(
        'update'   => 'category_list',
        'url'      => '@category_action',
        'with'     => "'articleId=".$article->getId()."&".$toggle."=".$categoryId."'",
        'loading'  => "Element.show('cat_indicator')",
        'complete' => "setTimeout('Element.hide(\'cat_indicator\')', 500)"
        )); ?>    <?php endif; ?>
	  <?php $seperator = " "; ?>
	  </span> 
	<?php endforeach; ?>  
<?php else: ?>
	<?php foreach ($eligibleCategories as $categoryId => $category):?>
	  <?php if (in_array($categoryId, $artworkCategories)): ?>
	    <?php echo ucfirst($category); ?><br />
	  <?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>
