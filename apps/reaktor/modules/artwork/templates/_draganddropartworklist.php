<?php

/**
 * List artwork as a draggable list so the user can prioritise them
 * Includes a generic artwork list view partial which can be reused when not using draggable lists
 * 
 * Variables this partial requires:
 * - $artworks : The array of artwork objects to list
 * - $thisUser : The user object we are working with
 * 
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

use_helper('Javascript');

?>

<?php if (count($artworks) > 0): ?>
  <ul id= "artwork_list">
    <?php foreach ($artworks as $artwork): ?>
      <li id = '<?php echo 'artwork_'.$artwork->getId() ?>' class="bottomborder">
      <?php /* For performance reasons we use pure PHP include, rather then include_[partial/component] (safes ~5seconds on 300includes */ ?>
      <?php include sfConfig::get("sf_root_dir") . '/apps/reaktor/modules/artwork/templates/_userArtworkListElement.php'; ?>
      </li>
    <?php endforeach; ?>
  </ul>
  
  <?php echo sortable_element('artwork_list', array(
    'url'    => 'artwork/updateArtworkOrder',
    'update' => 'feedback',
    'loading'  => "",
    'success'  => visual_effect('highlight', 'artwork_list'),
  )); ?>
<?php else: ?>
  <?php echo __("No artworks to sort"); ?>
<?php endif; ?>

