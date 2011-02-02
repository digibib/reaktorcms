<?php
/**
 * The reaktor site's main functionality is uploading artworks, but also providing useful articles for 
 * users and staff, where they can learn more about artworks, the system, etc. This template is for viewing an article.
 * The controller passes the following information:
 * 
 * $article - The article object to be viewed 
 * 
 * PHP version 5
 *
 * @author    Hannes Mangusson <bjori@linpro.no>
 * @author    Russell Flynn <russ@linpro.no> 
 * @author    June Henriksen <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */ 
?>

<div id="article_calendar_container" style="margin-top: 25px;" class="floatright">
<?php
  // Don't show a calendar for internal articles, help articles and..
  //if(in_array($article->getArticleType(), array(ArticlePeer::THEME_ARTICLE, ArticlePeer::MY_PAGE_ARTICLE, ArticlePeer::REGULAR_ARTICLE))):
    include_component("articles", "articleCalendar", array(
      "article_type" => $article->getArticleType(),
      "only"         => $article->getArticleType(),
      "article"      => $article,
      "article_id"   => $article->getId(),
      "edit"         => 0,
      "month"        => date("n", strtotime($article->getUpdatedAt())),
    ));
  /*else:
    include_component("articles", "browseTypes", array("view_article" => $article, 'edit' => 0));
  endif;*/
  //include_component('articles', 'articleCalendar', array('year' => $year, 'month' => $month, 'article_type' => $article_type, 'article_id' => $article->getId()));
?>
</div>
<div class="hentry" id="article_<?php echo $article->getId()?>">
  <div id="article_save" style="float: right;">
    <?php include_component('favourite','artworkListFavourites',array('artwork_id' => false, 'user_id' => false, 'article_id' => $article->getId(), 'list' => 'article', 'nofavload' => 'true')); ?>
  </div>

  <h2 class="entry-title">
  <?php echo $article->getTitle()?>
  <?php if ($sf_user->hasCredential("staff")): ?>
    [<?php echo link_to(__('Edit'), '@editarticle?article_id=' . $article->getId()); ?>]
  <?php endif ?>
  </h2>
  <?php 
  $published = strftime("%e. %B %Y", strtotime($article->getCreatedAt()));
  $changed   = strftime("%e. %B %Y", strtotime($article->getUpdatedAt()));
 ?>
  <dl class="publicated small_text faded_text" style="height: 15px;">
    <dt><?php echo __("Published:")?></dt>
    <dd><abbr class="published" title="<?php echo date(DATE_ATOM, strtotime($published)); ?>"><?php echo format_date($article->getCreatedAt(),'d. MMMM yyyy'); ?></abbr></dd>
  <?php if (date("Ymd", strtotime($published)) != date("Ymd", strtotime($changed))): ?>
    <dt><?php echo __("Last updated:")?></dt>
    <dd><abbr class="updated" title="<?php echo date(DATE_ATOM, strtotime($changed)); ?>"><?php echo format_date($article->getUpdatedAt(),'d. MMMM yyyy'); ?></abbr></dd>
  <?php endif ?>
  </dl>
  <?php if ($article->getIngress()): ?>
    <div class="entry-summary"><p><?php echo $article->getParsedIngress(); ?></p></div>
  <?php endif; ?>
  
  <div class="entry-content">
    <?php echo $article->getParsedContent(); ?>
  </div>
  
  <br class="clearboth" />
  <?php if ($rarticles = $article->getRelatedArticles(true)):?>
    <h4><?php echo __("Related articles")?></h4>
    <ul id="related_articles" class="floatleft">
    <?php foreach($rarticles as $rarticle): ?>
      <?php if ($rarticle->getArticleType() == ArticlePeer::INTERNAL_ARTICLE && $sf_user->hasCredential('staff')): ?>
        <li><?php echo link_to($rarticle->getTitle(), $rarticle->getLink())?></li>
      <?php elseif ($rarticle->getArticleType() == ArticlePeer::MY_PAGE_ARTICLE && $sf_user->isAuthenticated()): ?>
        <li><?php echo link_to($rarticle->getTitle(), $rarticle->getLink())?></li>
      <?php elseif (!in_array($rarticle->getArticleType(), array(ArticlePeer::INTERNAL_ARTICLE, ArticlePeer::MY_PAGE_ARTICLE))): ?>
        <li><?php echo link_to($rarticle->getTitle(), $rarticle->getLink())?></li>
      <?php endif; ?>
    <?php endforeach;?>
    </ul>
  <?php endif; ?>
  
  <?php if ($rartworks = $article->getRelatedArtwork()):?>
    <br class="clearboth" /><br />
    <h4><?php echo __("Related arworks")?></h4>
    <ul id="related_artworks" class="floatleft">
    <?php foreach($rartworks as $rartwork):?>
      <li><?php echo link_to($rartwork->getTitle(), $rartwork->getLink())?></li>
    <?php endforeach;?>
    </ul>
  <?php endif; ?>
  
  <?php if ($tags = $article->getTags()):?>
    <br class="clearboth" /><br />
    <h4><?php echo __("Tags") ?></h4>
    <?php include_partial("tags/viewTagsWithLinks", array("tags" => $tags)) ?>
  <?php endif ?>
  
  <?php do { ?>
    <?php if ($attachments = $article->getArticleAttachments()): ?>
      <?php // Don't do anything if we are a theme article with only one attachment, as that attachment is the theme banner ?>
      <?php if (($theme = $article->getArticleType() == ArticlePeer::THEME_ARTICLE) && count($attachments) == 1 ) break; ?>
      <br class="clearboth" /><br />
      <h4><?php echo __("Attachments") ?></h4>
      <ul id="article_attachments" class="floatleft">
      <?php foreach($attachments as $attachment): ?>
        <?php // Skip article banners ?>
        <?php if ($theme && $attachment->getArticleFile()->getId() == $article->getBannerFileId()) continue ?>
        <li><?php echo content_tag("a", $attachment->getArticleFile()->getFilename(), array("href" => $attachment->getArticleFile()->getDirectLink()))?></li>
      <?php endforeach ?>
      </ul>
    <?php endif ?>
  <?php } while(false); ?>
</div>

