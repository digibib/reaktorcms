<?php
/**
 * To determine which articles should be on top of lists, this template provides the possibility to 
 * drag and drop a list of articles with the same type. The action does not pass any parameters. 
 * 
 * The controller passes the following information:
 * 
 * $article_type : ArticlePeer::{type}_ARTICLE
 * $articles     : Article array
 *
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * 
 */ 
use_helper('content', 'Javascript');
?>


<?php $status = array(
  ArticlePeer::REGULAR_ARTICLE  => ArticlePeer::getArticleTypeName(ArticlePeer::REGULAR_ARTICLE),
  ArticlePeer::FOOTER_ARTICLE   => ArticlePeer::getArticleTypeName(ArticlePeer::FOOTER_ARTICLE),
  ArticlePeer::INTERNAL_ARTICLE => ArticlePeer::getArticleTypeName(ArticlePeer::INTERNAL_ARTICLE),
  ArticlePeer::MY_PAGE_ARTICLE  => ArticlePeer::getArticleTypeName(ArticlePeer::MY_PAGE_ARTICLE),
  ); ?>
  
 <br /> 
<?php if(!$article_id): //If article is chosen, don't allow change to other types?>
  <?php echo form_tag('@orderarticles') ?>
  <?php echo select_tag('status', options_for_select($status, $article_type), array(
    'onChange' => 'javascript:this.form.submit();')); ?>          
  </form>
<?php endif ?>



<?php if ($articles):?>

  <?php echo javascript_tag("

    function updateOrder()
    {
        dnd_s = document.getElementById('saving');
        dnd_d = document.getElementById('saved');
        dnd_d.style.display = 'none';
        dnd_s.style.display = 'inline';
        var options = {
                        method : 'post',
                        parameters : Sortable.serialize('article_ordered_list'),
                        onComplete : function(request) {
                          dnd_s.style.display = 'none';
                          dnd_d.style.display = 'inline';
                          dnd_d.innerHTML     = request.responseText;
                        }
                      };
     
        new Ajax.Request('".url_for("@orderarticlesupdate")."', options);
    }"
  ); ?>
  <br />
  <div style="display: none; font-weight: bold;" id="saving">
    <?php echo __("Vennligst venst mens rekkefølgen lagres...")?>
  </div>
  <div style="font-weight: bold; display: inline; margin-bottom: 10px;" id="saved">
    <?php echo __('Dra artiklene for å endre rekkefølgen.');?>
  </div>
  <br />
  
 
  <ul id="article_ordered_list" class="sortable-list">
  <?php foreach($articles as $article): ?>
    <li id="article_<?php echo $article->getId()?>"
        <?php if($article_id && $article_id==$article->getId()) echo 'style="background-color: #F58426"'?>>
     <h5><?php echo $article->getTitle().'  ['.$article->getStatus().']'; ?></h5>
        <?php $intro = $article->getTeaser(0, $tlen, $tcut, ArticlePeer::INGRESS); ?>
        <?php echo $intro ? $intro : $article->getTeaser(0, $len, $cut) ?>        
        <?php if ((isset($len, $cut) && $len > $cut) || !isset($len, $cut) && $article->getContent()): ?>
          <strong><?php echo reaktor_link_to(__('Read more'), $article->getLink()); ?></strong>
        <?php endif; ?>
    </li>
         
  <?php endforeach ?>     
  </ul>

  <?php echo javascript_tag(
    "Sortable.create('article_ordered_list', { onUpdate: updateOrder });"
  ) ?>


<?php else: //No articles ?>
  <?php echo __('Det finnes ingen artikler av denne typen.') ?>
<?php endif ?>
