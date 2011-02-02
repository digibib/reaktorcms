<?php
/**
 * Language links for top right of header
 *
 * PHP Version 5
 *
 * @author    Ole Petter Wikene <olepw@linpro.no>
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

$first = 1; 

?>

<?php foreach ($links as $link): ?>
  <?php if (!$first): ?>
    <?php echo " | " ?>
  <?php endif; ?>
  
  <?php $first = 0; ?>
  <?php echo link_to($link['description'], "@setLang?lang=".$link['lang']."&ref=".$ref, array('title'=>$link['description'],'class' => $link['class'])); ?>
<?php endforeach ?>

