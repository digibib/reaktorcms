<?php
/**
 * Component template to print a users most popular (approved) artworks  
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

<?php if(count($artworks)>1): ?>
  
  <h2><?php echo __('My most popular artworks')?></h2>
  <ul>
    <?php $counter = 0 ?>
    <?php foreach ($artworks as $artwork):?>
    
      <?php $file = $artwork->getFirstFile(); ?>
      <?php if($counter < 1): ?>
      
        <li>  
          <?php echo link_to(image_tag(
                                 url_for('@content_mini?id='.$file->getId().'&filename='.$file->getFilename()), 
                                 'size=70x60'), 
                             $artwork->getLink())?><br />        
          <?php echo link_to($artwork->getTitle(), $artwork->getLink()) ?>
          <?php echo showScore($artwork->getAverageRating()) ?>          
        </li>    
        
      <?php else: ?>      
        <li>                
          <?php echo link_to($artwork->getTitle(), $artwork->getLink()).showScore($artwork->getAverageRating()); ?>        
        </li>       
      <?php endif; ?>
       
      <?php $counter++ ?>
      
    <?php endforeach?>
  </ul>
  
<?php endif ?>