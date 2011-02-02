<?php
/**
 * List subreaktor categories and number of artworks in each
 *   
 * PHP version 5
 * 
 * @author    Daniel andre Eikeland <dae@linpro.no>
 * @author    June Henriksen <juneih@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
?>
<div class="subcategorydiv">
  <?php if (count($subreaktorcategories) > 0 || count($categories) > 0): ?>
  <ul>
  <?php endif ?>
  <?php foreach ($subreaktorcategories as $key=>$value): ?>
      <li class='subcategorylist'>
        <?php  echo link_to($key,'@subreaktorhome?subreaktor='.Subreaktor::getProvidedLokalReference().'-'.$value['reference'], array(
          'class'=>'subcategorylink')).'&nbsp;&nbsp;&nbsp;'.__('%number_of_artworks% artworks', array('%number_of_artworks%' => $value['count'])) ?>
      </li>
  <?php endforeach; ?>
  <?php foreach ($categories as $key=>$value): ?>
      <li class='subcategorylist'>
        <?php  echo link_to($key,'@subreaktorfindtags?subreaktor='.$subreaktor->getReference().'&tag='.$key, array(
          'class'=>'subcategorylink')).'&nbsp;&nbsp;&nbsp;'.__('%number_of_artworks% artworks', array('%number_of_artworks%' => $value)) ?>
      </li>
  <?php endforeach; ?>
  <?php if (count($subreaktorcategories) > 0 || count($categories) > 0): ?>
  </ul>
  <?php endif ?>
  
  <?php if (count($subreaktorcategories) == 0): ?>
    <?php echo __('This subReaktor has no categories'); ?>
  <?php endif ?>

</div>
