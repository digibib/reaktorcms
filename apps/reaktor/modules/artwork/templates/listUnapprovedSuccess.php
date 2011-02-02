<?php
/**
 * template for listing unapproved artworks
 *  
 * PHP version 5
 * 
 * @author    Ole-Petter Wikene <olepw@linpro.no>
 * @author    June Henriksen <juneih@linpro.no> 
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
use_helper('Javascript', 'content', 'PagerNavigation', 'Url');  
reaktor::setReaktorTitle(__('Unapproved artworks')); 

$selectedteam = ($team instanceof sfGuardGroup) ? $team->getId() : 0;

?>

<?php if ($sf_user->hasCredential('approveartwork')): ?>
  <?php if ($team): ?>
    <h1><?php echo __('Artworks pending queue - %team%', array('%team%' => $team->getDescription())) ?></h1>
  <?php elseif (isset($othereditorialteams)): ?>
    <h1><?php echo __('Artworks pending queue - all other teams') ?></h1>
  <?php else: ?>
    <h1><?php echo __('Artworks pending queue - my teams') ?></h1>
  <?php endif; ?>
<?php else: ?>
  <h2><?php echo __('Unapproved artworks by ') ?><?php echo $sf_user->getUsername() ?></h2>
<?php endif ?>
<hr class = "bottom_line" />
<?php if (isset($othereditorialteams) && $othereditorialteams): ?>
  <?php echo form_tag('@unapproved_listotherteams', array('style' => 'float: right;')) ?>
    <?php echo select_tag('team', options_for_select($othereditorialteamoptionslist, $selectedteam, array('include_custom' => __('All other teams') . ' (' . ReaktorArtworkPeer::getNumberofArtworksByEditorialTeam($othereditorialteams, 2, true) . ')')), array('onchange' => 'form.submit();')); ?>
  <?php echo '</form>'; ?>
<?php endif; ?>
<?php include_component('admin', 'adminArtworkList', array('artworks' => $artworks)); ?>
<?php $route = (isset($othereditorialteams)) ? '@unapproved_listotherteams' : '@unapproved_listmyteams' ?>
<?php echo pager_navigation($pager, $route) ?>
