<?php
/**
 * Print a comma seperated list of tags
 * 
 * Required parameters are detailed below:
 * - $tags : The list of tags              
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
?>
<?php $taglinks = array(); ?>
<?php foreach ($tags as $arrtag): ?>
  <?php foreach((array)$arrtag as $tag): ?>
    <?php $taglinks[] = reaktor_link_to($tag, '@findtags?tag='.$tag, array("rel" => "tag")) ?>
  <?php endforeach; ?>
<?php endforeach; ?>
<?php if ($taglinks): ?>
  <?php echo join(', ', $taglinks); ?>
<?php endif ?>

