<?php 
/**
 * The reaktor site's main functionality is uploading artworks, but also providing useful articles for
 * the regular users and staff. These articles can sometimes cover the same topic, and this template 
 * provide a way of relating articles to each other and displays a list of articles that have been 
 * related to each other
 * 
 * To use the component:
 * 
 * include_component('articles', 'articleRelations', array('article' => $article));
 * 
 * The component needs to pass the following:
 * $article- An article object
 * 
 * The controller passes the following
 * $related_articles - an array of article objects
 *
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

use_helper('Javascript', 'wai');
?>

<div id='relate_article'>
  <?php if (isset($unrelatedArticles) && count($unrelatedArticles) > 0): //There are articles to relate to?>
  
    <?php //Add form start tag 
        echo form_remote_tag(array(
        'update'   => 'relate_article', 
        'url'      => '@relatearticle?id='.$article->getId(),
        'loading'  => "Element.show('relate_article_ajax_indicator')",
        'complete' => "Element.hide('relate_article_ajax_indicator')",
        'script'   => true), array(
        'class' => 'relate_article_form', 
        'id'    => 'relate_article_form', 
        'name'  => 'relate_article_form'
    )) ?>

      <?php echo wai_label_for('relate_article_select', __('Relate an article')) ?>
      <br />
      <?php //Show spinning reaktor logo only when submitting ?>
      <div id = "relate_artwork_ajax_indicator" style="display: none">
        &nbsp;
        <?php echo image_tag('spinning18x18.gif', 'alt=spinning18x18')?>
      </div>
      <?php echo form_error('relate_article_select') ?>
      <?php echo select_tag("relate_article_select", options_for_select($unrelatedArticles, '', array(
          'include_custom' => __('--- Select an article to relate ---')
      ))) ?>
  
      <?php echo submit_tag(__('Relate article'), array(
         'class' => 'submit'
       )) ?>
    
    </form>
  <?php endif ?>
  
  <?php if (count($related_articles) > 0) : //print list of all related articles?>
    
    <h2><?php echo __('Related articles:') ?></h2>
    <ul id="related_articles">
    <?php foreach ($related_articles as $related_article): //List?>
      <li>
        <?php echo link_to($related_article->getTitle(), $related_article->getLink()) ?>
        
        <?php if($sf_user->isAuthenticated()&&$sf_user->hasCredential('staff')): //Add delete link if proper credentials?>      
          <?php echo link_to_remote(image_tag('delete.png', 'alt=delete.png size=10x10'), array(
            'update'   => 'relate_article', 
            'url'      => '@unrelatearticle?article1='.$article->getId().'&article2='.$related_article->getId(),
            //'loading'  => "Element.show('resource_ajax_indicator')",
            //'complete' => "Element.hide('resource_ajax_indicator')",
            'script'   => true,
          )) ?>
        <?php endif ?>
      </li>
    <?php endforeach ?>
    </ul>
  <?php endif ?>   
</div>
