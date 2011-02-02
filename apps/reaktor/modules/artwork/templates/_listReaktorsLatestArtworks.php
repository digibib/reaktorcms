<?php
/**
 * Component template to print a reaktors most popular (approved) artworks  
 *
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * 
 */
use_helper('home');
?>

<?php include_partial('feed/rssLink', array('description' => __('latest published'), 'slug' => 'latest_artworks')); ?>
<?php if (count($artworks) > 1 && !isset($text_or_artwork)): ?>  
  <ul>    
    <?php foreach ($artworks as $artwork):?>
        <li>
          <?php echo link_to($artwork->getTitle(), $artwork->getLink()) ?>
        </li>
    <?php endforeach?>
  </ul>
  
<?php else: ?>
  <?php if (count($artworks) >= 1 && isset($text_or_artwork)): ?>
  <ul>    
    <?php foreach ($artworks as $artwork):?>
        <li class='text_audio_subreaktor_rating_list'>
          <?php echo link_to($artwork->getTitle(), $artwork->getLink()) ?><br />
          <?php foreach ($artwork->getTags() as $category): ?>
            <?php echo $category,','; ?>
          <?php endforeach; ?>
        </li>
        <?php endforeach; ?>
  </ul>
 
  <?php else: ?>
    <?php echo __('There are no artworks published in this subReaktor.') ?> 
  <?php endif ?>
<?php endif ?>
