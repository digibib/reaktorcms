<?php
/**
 * Component template that displays rejected artworks. It does this by including a partial. 
 * The controller passes the following information:
 * 
 * $arts  - An array of reaktorArtwork objects
 * $pager - Provides paging when the list of artworks is getting longer.
 * 
 */

/**
 *  
 * PHP version 5
 * 
 * @author    Ole-Petter Wiknene <olepw@linpro.no>
 * @author    June Henriksen <juneih@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * TODO: Slide the rejection comments
 */

reaktor::setReaktorTitle(__('Rejected files')); 
reaktor::addJsToFooter("$('approved_calendar').setStyle({height: $('sidebar').offsetHeight + 'px'});"); 
use_helper('content', 'Javascript', 'PagerNavigation', 'Date');

?>

<?php if ($sf_user->hasCredential('approveartwork')): ?>
<div style="position: relative;">
  <div id="approved_calendar">
    <h4><?php echo __('Rejected artworks') ?></h4>
    <br />
    <ul class="year">
    <?php for($ccY = date('Y'); $ccY >= 2004; $ccY--): ?>
      <li><?php echo link_to($ccY . '&nbsp;(' . ReaktorArtworkPeer::countArtworksByDateAndStatus(4, $ccY) . ')', '@rejectedartwork_year?year='.$ccY); ?>
        <?php if ($selected_year == $ccY && !empty($months)): ?>
          <ul id="approved_<?php echo $ccY; ?>" class="months">
            <?php foreach($months as $month): ?>
              <li class="<?php if ($month['month'] == $selected_month) echo 'selected' ?>"><?php echo link_to(format_date(date('Y-m-d', mktime(null, null, null, $month['month'])), 'MMMM') . '&nbsp;(' . $month['artworkcount'] . ')', '@rejectedartwork_month?year='.$ccY.'&month='.$month['month']) ?></li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </li>
    <?php endfor; ?>
    </ul>
  </div>
  <div class="approved_main">
  <?php if (isset($selected_month)): ?>
      <h1><?php echo __('Rejected artworks %month% %year%', array('%month%' => format_date(date('Y-m-d', mktime(null, null, null, $selected_month, 1, $selected_year)), 'MMMM'), '%year%' => $selected_year)) ?></h1>
      <?php include_component('admin', 'adminArtworkList', array('artworks' => $artworks)); ?>
      <?php echo pager_navigation($pager, $route); ?>
  <?php else: ?>
    <?php echo __('Please select a month in the list to the left') ?>
  <?php endif; ?>
  </div>
</div>
<?php endif; ?>
