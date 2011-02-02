<?php
/**
 * List subreaktor categories and number of artworks in each
 *   
 * PHP version 5
 * 
 * @author    June Henriksen <juneih@linpro.no>
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
?>
<div class="subcategorydiv">
  <h1><?php echo __('Categories'); ?></h1>
  <?php if ( isset($categories) &&  count($categories)): ?>
    <ul>
    <?php foreach ($categories as $key => $value): ?>
        <li class='subcategorylist'>
            <?php  echo reaktor_link_to($key,'@findcategory?category='.$key, array(
            'class'=>'subcategorylink')); ?>
            <span class = "smallishindent">
            <?php echo format_number_choice("[0]No artworks|[1]1 artwork|[1,+Inf]%1% artworks", 
            array("%1%" => $value), $value); ?>
            </span>
        </li>
    <?php endforeach; ?>
    </ul>
  <?php else:  ?>
    <?php echo __('This subReaktor has no categories'); ?>
  <?php endif ?>
</div>
