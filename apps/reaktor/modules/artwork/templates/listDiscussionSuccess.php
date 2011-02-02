<?php 
/**
 * Before an artwork is displayed on the Reaktor site, it has to be evaluated by a staff member, 
 * who either approves or rejects the artwork. In order to help with this decision making the 
 * staff has the opportunity to invite other members to discuss an artwork. The individual files 
 * on each approved artwork can be reported by users.  Before removing  a file from the site, 
 * these files can be discussed in the same way artworks can.
 * 
 * This template provides a list of all artworks and files flagged for discussion. 
 * 
 * The controller passes the following information:
 * 
 * $artworks - an array of genericArtworks
 * $files    - an array of artworkFiles
 * 
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

use_helper('Javascript', 'content');
reaktor::setReaktorTitle(__('Artwork discussion'));

?>

<h1><?php echo __("Under discussion") ?></h1>
<hr class = "bottom_line" />
<br />

<?php if (count($files) + count($artworks) > 0): //artworks or files found?>

<ul>
  <?php foreach ($artworks as $artwork): //List artworks?>
    <li id="artwork_list_container_<?php echo $artwork->getId()?>" class='artwork_list'>
      <?php include_partial('artwork/displayArtworkInList', array(
        'artwork'       => $artwork, 
        'update_div'    => 'artwork_list_container_'.$artwork->getId(),
        'buttonPartial' => 'admin/discussButtons')); ?>
    </li>
  <?php endforeach; ?>
  <?php foreach ($files as $file): //List files?>
    <li id="artwork_list_container_f_<?php echo $file->getId()?>" class='artwork_list'>
      <?php include_partial("artwork/displayFileInList", array(
        "file"          => $file, 
        'update_div'    => 'artwork_list_container_f_'.$file->getId(),        
        "buttonPartial" => "admin/discussButtons")); ?>    
    </li>
</ul>   
 
<?php endforeach; ?> 


<?php else : //No artworks or files have been marked for discussion?>
  <p>
    <?php echo __('No content is currently under discussion'); ?>
  </p>
<?php endif; ?>