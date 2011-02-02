<?php
/**
 * Page to list results of searches
 * 
 * Values to search can be passed directly on the URL, triggered via the search box in the sidebar, 
 * or through clicks on tags and categories. It is possible to get results from tags or categories.
 * 
 * User searches can also be dealt with via this page, if the form is posted with "findype" = "user"
 * 
 * The following parameters are sent to the template by the action:
 * - $mode          : this is the search mode (tag or category)
 * - $tags          : These are the individual tags that are being searched
 * - $categories    : These are the individual categories that are being searched
 * - $sortmode      : This is the current sort mode (date, title, rating, username)
 * - $sortdirection : The current sort direction (asc, desc) 
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

use_helper('content', 'home', 'Cache');
if (isset($tags)) reaktor::setReaktorTitle(__("Search for %search_items%", array("%search_items%" => implode(", ", $tags))));
elseif (isset($categories)) reaktor::setReaktorTitle( __('work in %category% category', array("%category%" => $categories)));

?>

<?php if (count($results) > 0): ?>
  <div class='relative'>
    <?php if ($mode == 'tag'): ?>
      <?php include_partial('tags/sortlinks', 
            array('tags' => $tags, 'mode' => $mode, 'sortmode' => $sortmode, 'sortdirection' => $sortdirection, 'results' => $results)); ?>
    <?php else: ?>
      <?php include_partial('tags/sortlinks', 
            array('categories' => $categories, 'mode' => $mode, 'sortmode' => $sortmode, 'sortdirection' => $sortdirection, 'results' => $results)); ?>
    <?php endif; ?>
    
    <?php if (isset($results["Article"])): ?>
      <div class = "relative">  
        <?php foreach($results["Article"] as $tag => $articleMatches): ?>
          <br />
          <div class = 'relative' id="article_search_tag_<?php echo $tag ?>">
            <?php if ($mode == "category"): ?>
              <?php include_partial('feed/rssLink', array('description' => __('articles in %category% category', array("%category%" => $tag)), 'slug' => 'articles_in_category_'.$tag)); ?>
              <h2><?php echo __("Articles in %category% category", array("%category%" => $tag)); ?> (<?php echo count($articleMatches); ?>)</h2>
            <?php else: ?>
              <?php include_partial('feed/rssLink', array('description' => __('articles tagged with %tag%', array("%tag%" => $tag)), 'slug' => 'articles_tagged_with_'.$tag)); ?>
              <h2><?php echo __("Articles tagged with %tag%", array("%tag%" => $tag)); ?> (<?php echo count($articleMatches); ?>)</h2>
            <?php endif; ?>
            <?php foreach ($articleMatches as $article): ?>
              <div class = "article_result_row"> 
                <h4><?php echo reaktor_link_to($article->getTitle(), $article->getLink()); ?></h4>
                <p>
                  <?php echo __("Last updated on %publish_date% at %publish_time% ", 
                          array("%publish_time%" => date("H:i", strtotime($article->getUpdatedAt())),
                                "%publish_date%" => date("d/m/Y", strtotime($article->getUpdatedAt())))); ?>
                </p>
                <br />
                <p>
                  <?php echo nl2br($article->getIngress()); ?>
                  <?php if ($article->getContent()): ?>
                    <?php echo " [ ".reaktor_link_to(__("Read more..."), $article->getLink())." ]"; ?>
                  <?php endif; ?>
                </p>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endforeach; ?> 
        <br />
        <?php if (count($results["Article"]) > 1): ?>
          <?php $justTags = array_keys($results["Article"]); ?>
          <?php include_partial('feed/rssLink', 
                array('description' => __('articles tagged with %tags%', 
                array("%tags%" => implode(', ', $justTags))), 
                        'slug' => 'articles_tagged_with_'.implode('_', $justTags), 
                        'class' => 'bottom_right_outside',
                        'caption' => __('Subscribe to this result set'))); ?>
        <?php endif; ?>
      </div>
    <?php endif; ?>
    
    <?php if (isset($results["genericArtwork"])): ?>
      <div class = "relative">
        <?php foreach ($results["genericArtwork"] as $tag => $matches): ?>
          <br />
          <div class = 'relative' id="artwork_search_tag_<?php echo $tag ?>">
            <?php if ($mode == "category"): ?>
              <?php include_partial('feed/rssLink', array('description' => __('work in %category% category', array("%category%" => $tag)), 'slug' => 'in_category_'.$tag)); ?>
              <h2><?php echo __("Work in %category% category", array("%category%" => $tag)); ?> (<?php echo count($matches); ?>)</h2>
            <?php else: ?>
              <?php include_partial('feed/rssLink', array('description' => __('work tagged with %tag%', array("%tag%" => $tag)), 'slug' => 'tagged_with_'.$tag)); ?>
              <h2><?php echo __("Work tagged with %tag%", array("%tag%" => $tag)); ?> (<?php echo count($matches); ?>)</h2>
            <?php endif; ?>
            <?php foreach ($matches as $match): ?>
              <div class="searchresult_row">
                <div class = "float_right">
                  <?php echo showScore($match->getAverageRating()); ?>
                </div>
        	      <?php echo reaktor_link_to(image_tag(contentPath($match, "mini"), array('size' => '78x65', 'alt' => $match->getTitle(), 'title' => $match->getTitle())), 
									    $match->getLink()); ?>
        	      <h4>
          	      <?php $tmp_artwork_title = reaktor_link_to($match->getTitle(), 
          	    	                                                "@show_artwork?id=".$match->getId().
                                                      	    	  "&title=".$match->getTitle()); ?>
                      <?php
                      $tmp_username = reaktor_link_to($match->getUser()->getUsername(), "@portfolio?user=".$match->getUser()->getUsername());
                      $tmp_username = '<span class="username">' .$tmp_username. '</span>';
                      echo __('%artwork_title% by %username%', 
                          array('%artwork_title%' => $tmp_artwork_title, 
                                '%username%' => $tmp_username)); ?>
                </h4>
    
                <?php echo __('uploaded at %upload_time% on %upload_date%', 
                        array('%upload_time%' => date("H:i", strtotime($match->getCreatedAt())),
                              '%upload_date%' => date("d/m/Y", strtotime($match->getCreatedAt())))); ?>
                <br />
        	      <div class="taglist">
      			      <?php $taglinks = array(); ?>
        			    <?php foreach ($match->getTags() as $aTag): ?>
        			      <?php $taglinks[] = reaktor_link_to($aTag, '@findtags?tag='.$aTag, array("rel" => "tag")); ?>
        			    <?php endforeach; ?>
        			    <?php if (!empty($taglinks)): ?>
	      			      <?php echo join(', ', $taglinks); ?>
  	    		      <?php endif; ?>
        	      </div>
              </div>
      		  <?php endforeach; ?>
      		</div>
          <br />
        <?php endforeach; ?>
        <?php if (count($results["genericArtwork"]) > 1): ?>
          <?php $justTags = array_keys($results["genericArtwork"]); ?>
          <?php include_partial('feed/rssLink', 
                array('description' => __('work tagged with %tags%', 
                array("%tags%" => implode(', ', $justTags))), 
                      'slug' => 'tagged_with_'.implode('_', $justTags), 
                      'class' => 'bottom_right_outside',
                      'caption' => __('Subscribe to this result set'))); ?>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
<?php else: //No matches found ?>
  <br />
  <?php if ($sf_params->get('tag')): ?>
    <?php if ($sf_params->get("findtype") == "user"): $search_type = __("users"); ?>
    <?php else: $search_type = __("tags"); ?>
    <?php endif; ?>
    <?php echo __("There are no %search_type% matching %search_string%, however, you could try these tags:", 
          array("%search_type%" => $search_type, "%search_string%" => "<b>".$sf_params->get("tag")."</b>")); ?> 
  <?php else: //nothing entered in search box?>
    <?php echo __('You have to enter something to search for. Here are some you could try:') ?>
  <?php endif ?>  
  <br /><br />
  <?php
  echo tag_cloud(TagPeer::getPopulars(), '@findtags?tag=', 
       array('class' => 'tag-cloud-right', 'parent_approved' => 1, 
             'subreaktor' => Subreaktor::getProvidedSubreaktor(), 'lokalreaktor' => Subreaktor::getProvidedLokalreaktor()));
  
  ?> 
<?php endif; ?>
