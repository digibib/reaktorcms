<?php
/**
 * Partial that lists an array of articles. Can be included anywhere, just by passing an
 * array of Article objects + list style (defaults to title+intro+read more)
 * 
 * $articles: An array of articles
 * $mode:     Display mode - "short" for clickable title only, "full" for title+intro+link (default) 
 *
 *
 * NOTE: This partial will NOT list more articles than the max count of articles 
 * to be shown for the first article type
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

  $mode = (isset($mode)) ? $mode : 'full';
  $current = current($articles);
  if ($current) {
    $type = current($articles)->getArticleType();
  }
  else {
    $type = -1; // Just use the default count
  }
  $breakAt = ArticlePeer::getShowCountFor($type);
  $count   = 0;

?>
<?php if (count($articles)): ?>
  <ul class="article_list_<?php echo $mode; ?>" style="overflow: hidden;">
<?php endif; ?>

	<?php foreach($articles as $article): ?>
    <?php if(++$count > $breakAt) break; ?>
    <?php $content=$article->getContent(); ?>
    <li>
    <?php if ($mode == 'theme'): ?>
    <?php
        $filename = strtolower($article->getBannerFile()->getDirectLink()) ;
        $exts = split("[/\\.]", $filename) ;
        $n = count($exts)-1;
        $exts = $exts[$n]; 
    ?>

    <?php if ($exts == 'swf'): ?>
    
    <?php echo '<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/ flash/swflash.cab#version=4,0,0,0" ID=ad_banner_example1 WIDTH=240 HEIGHT=160>'.
		'<param name="movie" value="'.$article->getBannerFile()->getDirectLink().'?clickTAG='.urlencode(url_for($article->getLink())).'"> '.
        '<embed src="'.$article->getBannerFile()->getDirectLink().'?clickTAG='.urlencode(url_for($article->getLink())).'" width="240" height="160" TYPE="application/x-shockwave-flash" >'.
		'</embed>'.
		'</object>'; ?>

    <?php else: ?>
      <?php echo reaktor_link_to(image_tag($article->getBannerFile()->getDirectLink(), array("alt" => $article->getTitle())), $article->getLink()); ?>
    <?php endif; ?>
 
    <?php elseif ($mode == 'short' || $mode == 'footer'): ?>
      <?php echo reaktor_link_to($article->getTitle(), $article->getLink()); ?>
    <?php elseif ($mode == 'full'): ?>
      <h5><?php echo $article->getTitle(); ?></h5>
      <?php $intro = (empty($content) ? $article->getIngress() : $article->getTeaser(0, $tlen, $tcut, ArticlePeer::INGRESS) ); ?>
      <?php if ($intro): ?>
        <?php echo $intro ?>
      <?php else: ?>
        <?php $temptext = preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)@', '<a href="$1">$1</a>', $article->getTeaser(0, $len, $cut)) ?> 
        <?php echo $temptext ?>
      <?php endif ?>      
      <?php if ((isset($len, $cut) && $len > $cut) || !isset($len, $cut) && trim($content)): ?>
        <strong><?php echo reaktor_link_to(__('Read more'), $article->getLink()); ?></strong>
      <?php endif; ?>
    <?php endif; ?>
    </li>
    
	<?php endforeach; ?>
<?php if (count($articles)): ?>
  </ul>
<?php endif; ?>

