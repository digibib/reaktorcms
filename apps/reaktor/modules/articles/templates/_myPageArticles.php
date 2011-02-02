<?php
/**
 * Shows the my page articles
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
?>
<?php if ($articles): ?>
  <div id="mypage_articles" class="colored_article_container">
  	<?php include_partial('articles/articleList', array('articles' => $articles)); ?>
  </div>
<?php endif ?>
