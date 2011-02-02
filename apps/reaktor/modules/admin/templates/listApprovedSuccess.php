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

use_helper('Javascript', 'content', 'Url', 'PagerNavigation', 'Date');
reaktor::setReaktorTitle(__('List approved artworks'));
reaktor::addJsToFooter("$('approved_calendar').setStyle({height: $('sidebar').offsetHeight + 'px'});"); 

?>

<?php if ($sf_user->hasCredential('approveartwork')): ?>
<div style="position: relative;">
  <div id="approved_calendar">
    <h4><?php echo __('Approved artworks') ?></h4>
    <br />
    <ul class="year">
    <?php for($ccY = date('Y'); $ccY >= 2004; $ccY--): ?>
      <li><?php echo link_to($ccY . '&nbsp;(' . ReaktorArtworkPeer::countArtworksByDateAndStatus(3, $ccY) . ')', '@approvedartwork_year?year='.$ccY); ?>
        <?php if ($selected_year == $ccY && !empty($months)): ?>
        <ul id="approved_<?php echo $ccY; ?>" class="months">
				    <?php foreach($months as $month): ?>
				      <li<?php if ($month['month'] == $selected_month) echo ' class="selected"' ?>><?php echo link_to(format_date(date('Y-m-d', mktime(null, null, null, $month['month'])), 'MMMM') . '&nbsp;(' . $month['artworkcount'] . ')', '@approvedartwork_month?year='.$ccY.'&month='.$month['month']) ?></li>
				    <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </li>
    <?php endfor; ?>
    </ul>
  </div>
  <div class="approved_main">
  <?php if (isset($selected_month)): ?>
    <h1><?php echo __('Approved artworks %month% %year%', array('%month%' => format_date(date('Y-m-d', mktime(null, null, null, $selected_month, 1, $selected_year)), 'MMMM'), '%year%' => $selected_year)) ?></h1>
	    <?php include_component('admin', 'adminArtworkList', array('artworks' => $artworks)); ?>
      <?php echo pager_navigation($pager, $route); ?>
  <?php else: ?>
    <?php echo __('Please select a month in the list to the left') ?>
  <?php endif; ?>
  </div>
</div>
<?php endif; ?>
