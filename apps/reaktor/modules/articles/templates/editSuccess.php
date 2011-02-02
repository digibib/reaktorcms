<?php
/**
 * The reaktor site's main functionality is uploading artworks, but also providing useful articles for 
 * the regular users and staff. This template lets staff users create and edit an article. It does this 
 * by using compoments and partials. The controller passes the following information:
 * 
 * $article - an article object
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @author    June Henriksen <juneih@linpro.no>
 * @author    Hannes Magnusson <bjori@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
use_helper('Javascript', 'button');
?>
<?php if ($article->getId()): ?>
  <div id="article_calendar_container" class="floatleft">
    <?php include_component('articles', 'articleCalendar', array('year' => $year, 'month' => $month, 'article_type' => $article_type, 'article_id' => $article->getId(), 'edit' => 1, 'live' => 0)); ?>
  </div>
<?php endif; ?>
<div id="article_editing_container" class="smallishindent">
  <?php if ($sf_request->hasErrors()): ?>
    <p id = 'errormsg'>
      <?php echo image_tag('cancel.png')." ".__('The article was not saved!'); ?>
      <?php echo __('Please correct the errors below and save again'); ?>
    </p>
  <?php endif; ?>
	<div id="article_main_container" class="article_container">
    <?php include_partial('editarticlecontents', array(
                          'article' => $article, 
                          'buttons' => $show_attachments_edit)); ?>
	</div>
	
  
  <?php if ($show_expiry_date): ?>
    <div id="expirationDate">
      <?php include_component('articles', 'expirationDate', array('article' => $article)); ?>
    </div>
  <?php endif; ?>
  <?php if ($show_subreaktor_and_categories_edit): ?>
    <div id="categorySelect" style="width: 250px; float: left;">
      <?php include_component('artwork', 'categorySelect', array('article' => $article)); ?>
    </div>
  <?php endif; ?>
  <div id="article_tags_container" style="width: 250px; float: left;">
	  <?php if ($show_tags_edit): ?>
	    <?php include_partial('tags/tagWrapper', array('thisObject' => $article)); ?>
	  <?php endif; ?>
  </div>
  <br class="clearboth" />
  <?php if ($show_related_edit): ?>
    <div id="article_related_articles_container" class="article_container">
      <?php include_component('articles','articleRelations', array('article'=> $article)) ?>
    </div>
  <?php endif; ?>
  <?php if ($show_attachments_edit): ?>
    <?php include_component('articles', 'articleAttachments', array(
      'article'=> $article, 
      'banner' => $show_banner,)) ?>
  <?php endif; ?>
  <?php if ($show_related_artworks_edit): ?>
    <?php include_component('articles', 'articleRelatedArtworks', array('article'=> $article)) ?>
  <?php endif; ?>
  
  <?php if( isset($order) && $order):?>
     <h2> <?php echo __("Prioritere artikkel") ?></h2>
     <?php echo __('Før du publiserer denne artikkelen, bør du ') ?>
    <b><?php echo link_to(__('velge '), '@orderarticles?only=1&status='.$article->getArticleType().'&article='.$article->getId(), array(
    'class'  => "lightwindow", 
    "closetext" => __("close"),
    'params' => "lightwindow_type=external,lightwindow_width=980,lightwindow_height=800", 
    'title'  => 'Artikkelprioritering')) ?></b>
    <?php echo __('hvor høyt den skal prioriteres i lister. ') ?>
  <?php endif ?>  
    
</div>

