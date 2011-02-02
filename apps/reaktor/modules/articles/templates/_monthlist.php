<?php
/**
 * 
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
?>
<?php foreach ($articles as $anarticle): ?>
  <?php if ($article->getId() == $anarticle->getId()): ?>
  <li class="orange"><?php echo $anarticle->getTitle(); ?></li>
  <?php else: ?>
    <?php if ($edit): ?>
      <li><?php echo reaktor_link_to($anarticle->getTitle(), '@editarticle?article_id='.$anarticle->getId()); ?></li>
    <?php else: ?>
      <li><?php echo reaktor_link_to($anarticle->getTitle(), $anarticle->getLink()); ?></li>
    <?php endif ?>
  <?php endif; ?>
<?php endforeach; ?>
