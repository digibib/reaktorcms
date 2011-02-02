<?php
/**
 * Article calendar left-hand sidebar
 * Included in article edit page and on article list page 
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

use_helper('Javascript','Date');

reaktor::addJsToFooter("$('article_calendar_container').setStyle({height: $('sidebar').offsetHeight + 'px'});"); 

if ($only):
  $types = is_array($only) ? $only : array($only => __("Archive"));
else:
  /*$only = false;*/
  $types = ArticlePeer::getArticleTypesByPermission($sf_user);
endif;

?>

<div id="article_calendar">
<h2>
<?php
if (in_array($status, array(ArticlePeer::DRAFT, 'draft'))):
  echo __("Drafts");
elseif (in_array($status, array(ArticlePeer::PUBLISHED, 'published'))):
  echo __("Published");
elseif (in_array($status, array(ArticlePeer::ARCHIVED, 'archived'))):
  echo __("Archived");
else:
  echo __("All articles");
endif;
?>
</h2>
  <?php foreach ($types as $type_id => $type_name): ?>
    <div id="article_calendar_<?php echo $type_id; ?>" class="<?php if ($article_type == $type_id) echo 'article_type_list_selected'; ?>">
	    <?php if ($article_type == $type_id): //Chosen type header?>
	      <h4><?php echo $type_name; ?></h4>
          <?php if (in_array($type_id, array(ArticlePeer::INTERNAL_ARTICLE, ArticlePeer::FOOTER_ARTICLE, ArticlePeer::SPECIAL_ARTICLE))): ?>
		        <?php if (!$articles[$type_id]): ?>
		          <p><?php echo __("No articles for this type yet"); ?></p>
		          </div><?php // close the article_calendar_id div!! ?>
		          <?php continue; ?>
            <?php else: ?>
			        <ul class="year">
	              <?php foreach($articles[$type_id] as $anarticle): ?>
                  <?php if ($article->getId() == $anarticle->getId()): ?>
                    <li class='differ'><?php echo $article->getTitle(); ?></li>
                  <?php else: ?>
		                <?php if ($edit): ?>
		                  <li><?php echo reaktor_link_to($anarticle->getTitle(), '@editarticle?article_id='.$anarticle->getId()); ?></li>
		                <?php else: ?>
		                  <li class="editablearticle"><?php echo reaktor_link_to($anarticle->getTitle(), $anarticle->getLink()); ?></li>
		                <?php endif ?>
                  <?php endif; ?>
	              <?php endforeach; ?>
	            </ul>
            <?php endif; ?>
          <?php elseif ($type_id == ArticlePeer::HELP_ARTICLE): ?>
            <?php foreach ($formats as $formats_ref): ?>
			        <?php foreach ($formats_ref as $reference => $format): //Print the rest of the formats?>
			          <h4 class='capitalize'>
                <?php echo link_to_remote($format['name'], array(
                           'update'   => 'article_calendar',
                           'url'      => '@articlecalendar_type?article_type='.$type_id.'&article_id='.$article->getId().
                                                                '&edit='.$edit.(($only) ? '&only='.$only : '').
                                                                '&chosen_format='.$reference. '&status=' .$status.
                                                                '&live='.$live
                            ));?>
			          </h4>
			          <?php if ($chosen_format && $chosen_format == $reference): //This format has been selected to be opened, print all helparticles in the format?>            
                  <ul class="year">
                    <?php if (count($format['articles']) > 0): ?>
					            <?php foreach($format['articles'] as $view_article): ?>
					              <?php if ($article->getId() == $view_article->getId()): //This is the article being viewd?> 
					               <li class='differ'><?php echo $article->getTitle(); ?></li>
					              <?php else: ?> 
                          <?php if ($edit): ?>
                            <li><?php echo reaktor_link_to($view_article->getTitle(), '@editarticle?article_id='.$view_article->getId()); ?></li>
                          <?php else: ?>
                            <li class="editablearticle"><?php echo reaktor_link_to($view_article->getTitle(), $view_article->getLink()); ?></li>
                          <?php endif; ?>
					              <?php endif; ?>
					            <?php endforeach; ?>
                    <?php else: ?>
                      <li><?php echo __("No articles for this type yet"); ?></li>
                    <?php endif; ?>
                  </ul>
                  <br />
			          <?php endif; ?>
			        <?php endforeach; ?>
            <?php endforeach; ?>
          <?php else: ?>
            <ul class="year">
	            <?php foreach($articles[$type_id] as $year => $a): ?>
					      <li id="articleyear_<?php echo $year; ?>">
			            <?php echo $year; ?>
										<ul class="months">
			                <?php foreach($a as $month => $as): ?>
										    <li id="articlemonth_<?php echo $month; ?>">
			                    <?php echo format_date(date("F", mktime(0, 0, 0, $month, 1)),'MMMM'); ?> (<?php echo count($as); ?>)
					                <?php if ($as): ?>
					                  <ul class="articlelist">
			                        <?php foreach($as as $anarticle): ?>
							                  <?php if ($article->getId() == $anarticle->getId()): ?>
							                    <li class='differ'><?php echo $article->getTitle(); ?></li>
							                  <?php else: ?>
				                          <?php if ($edit): ?>
				                            <li><?php echo reaktor_link_to($anarticle->getTitle(), '@editarticle?article_id='.$anarticle->getId()); ?></li>
				                          <?php else: ?>
				                            <li class="editablearticle"><?php echo reaktor_link_to($anarticle->getTitle(), $anarticle->getLink()); ?></li>
				                          <?php endif ?>
                                <?php endif; ?>
		                          <?php endforeach; ?>
					                  </ul>
					                <?php endif; ?>
										    </li>
										  <?php endforeach; ?>
										</ul>
					      </li>
              <?php endforeach; ?>
            </ul>
            <?php if (!$articles[$type_id]): ?>
              <p><?php echo __("No articles for this type yet"); ?></p>
              </div><?php // close the article_calendar_id div!! ?>
              <?php continue; ?>
            <?php endif; ?>
          <?php endif; ?>
          
      <?php else: //The rest of the type headers?>
        <?php echo link_to_remote($type_name, array(
                   'update'   => 'article_calendar',
                   'url'      => '@articlecalendar_type?article_type='.$type_id.'&edit='.$edit.(($only) ? '&only='.$only : '').
                                                        '&article_id='.$article->getId(). '&only=' .$only. '&status=' .$status.
                                                        '&live='.$live
                    ));?>
      
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
</div>

