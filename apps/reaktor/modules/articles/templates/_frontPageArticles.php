<?php
/**
 * Front page article partial. Can be included on any frontpage, and will show general articles
 * not restricted to a subreaktor, and articles that are available only in the subreaktor you're
 * watching. 
 * 
 * Does not take any parameters.
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
?>
<?php if ($theme_article): ?>
  <div class="article_summary_block" style="background-color: #fff; width: 240px; padding: 0px; ">
    <?php include_partial('articles/articleList', array('articles' => $theme_article, 'mode' => 'theme')); ?>
  </div>
<?php else: ?>
	<div class="article_summary_block" >
    <?php include_partial('articles/articleList', array('articles' => $articles)); ?>
  </div>
<?php endif; ?>

