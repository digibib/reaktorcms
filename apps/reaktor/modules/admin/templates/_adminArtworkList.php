<?php
/**
 * Artworks and files are on Reaktor sometimes presented in lists. The reaktor backend has most of these lists: 
 * rejected, approved, unapproved, under discussion etc. To keep a more or less similar look on all
 * lists, a single template is used, this one.
 * 
 * Ex.: include_partial('admin/adminArtworkList', array('files' => $files))
 * Ex.: include_component('admin', 'adminArtworkList', array('artworks' => $artworks, 'show_recommended' => true))
 * 
 * This template gets all of its information from the parameters passed
 * - $files            : An array of files
 * - $artworks         : Array of artworks
 * - $show_recommended : If this is passed, the subreaktors this file is recommended are displayed 
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @author    June Henriksen <juneih@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
$rowCount = 0;
?>
<ul id ="artwork_list">
<?php if (isset($artworks) && !count($artworks)):  //ARTWORKS?>
  <li><?php echo __('No artworks') ?></li>
  
<?php elseif (isset($artworks)): //artworks found?>
	<?php foreach ($artworks as $art): //Print list of artworks?>
	
    <?php if (is_array($art)): ?>
      <?php $artwork = $art['artwork']; ?>
    <?php else: ?>
      <?php $artwork = $art; ?>
    <?php endif; ?>
    <?php $rowCount++; ?>
	  <li id="artwork_list_container_<?php echo $artwork->getId()?>" class='artwork_list <?php echo ($rowCount % 2) ? "evenrow" : "";?>' >
    <?php if (!isset($show_recommended)): ?>
	    <?php include_partial('artwork/displayArtworkInList', array('artwork' => $artwork,'showDetails'=>true)); //Display artwork?>
	    <?php include_partial("artwork/adminButtons", array(
        'object' => $artwork, 
        'type' => 'artwork' )) ?>        
    <?php else: //Show which subreaktors the artwork is recommended in... ?>
	    <?php include_partial('artwork/displayArtworkInList', array('artwork' => $artwork, 'show_recommended_at' => $art["updatedat"])); //Display artwork?>
        <div class = "indent_artwork_list">
          <h4><?php echo __('Recommended in %list_of_reaktors%:', array('%list_of_reaktors%' => '')); ?></h4>
          <?php if ($art['subreaktor']->getLokalreaktor()): ?>
            <?php echo $art['subreaktor']->getReference() . '-' . $art['lokalreaktor']->getReference(); ?>
          <?php else: ?>
            <?php echo $art['subreaktor']->getReference(); ?>
          <?php endif; ?>
        </div>
    <?php endif ?>
	  </li>
	  
	<?php  endforeach ?>
<?php endif; ?>

<?php if (isset($files) && !count($files)): //FILES?>
  <li><?php echo __('No files') ?></li>
<?php elseif (isset($files)): //files found?>

	<?php foreach ($files as $key => $file): //Print list of files?>
    <li id="artwork_list_container_<?php echo $file->getId()?>" class='artwork_list' >
      <?php include_partial('artwork/displayFileInList', array('file' => $file)); //Display file?>
          <div id='rejection_message_<?php echo $file->getId() ?>' style='display: none'>
            <?php echo $file->getRejectedMessage() ?>
          </div>          
      <?php include_partial('artwork/adminButtons', array(
        'object' => $file,
        'type'   => 'file',
        'showRejectionMsg'   => 'rejection_message_'.$file->getId()
      )) //Display buttons?>
      <?php if($file->isUnsuitable()): //Print rejected message in lightwindow box?>
      <?php  endif ?>
    </li>
	<?php endforeach; ?>
	
<?php endif; ?>
</ul>
