<?php
/**
 * Display a calendar with information and how many comments where made that day, with link to it.
 *
 * PHP version 5
 *
 * @author juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
 ?>

<h2 class='cal_comm_hdr'> <?php echo __('Comments made in ').__(date('F', strtotime($date))) ?> </h2>
<div class="calendar_component">
<table id='calendar'>
<caption> 
<?php echo link_to_if(isset($prev_month), __(date('F', strtotime($prev_month))), '@commentscalendar?date='.$prev_month)?>
<?php echo ' '.__(date('F', strtotime($date))).' ' ?>
<?php echo link_to_if(isset($next_month),  __(date('F', strtotime($next_month))), '@commentscalendar?date='.$next_month)?>
</caption>
 <tr>
  <th scope="col" abbr="Monday" title="Monday" class="cal_hdr">Mon</th>
  <th scope="col" abbr="Tuesday" title="Tuesday" class="cal_hdr">Tue</th>
  <th scope="col" abbr="Wednesday" title="Wednesday" class="cal_hdr">Wed</th>
  <th scope="col" abbr="Thursday" title="Thursday" class="cal_hdr">Thu</th>
  <th scope="col" abbr="Friday" title="Friday" class="cal_hdr">Fri</th>
  <th scope="col" abbr="Saturday" title="Saturday" class="cal_hdr">Sat</th>
  <th scope="col" abbr="Sunday" title="Sunday" class="cal_hdr">Sun</th>
 </tr>

  <?php foreach ($calendar as $week):?>
    <tr>
      <?php foreach ($week as $day => $event): ?>
        <?php echo ($day == date('Y-m-d')) ? '<td class="today"> <p>' : '<td class="day"><p id="comment_count">'?>        
        <div><?php echo  date('j', strtotime($day)) ?></div>
        
        <?php if (!empty($event)):?>          
      <?php echo link_to_if(isset($event['url']), $event['count'], $event['url']) ?>
        <?php else: ?>
         <?php echo '<br />' ?>    
        <?php endif ?>
        </p>
        </td>
      <?php endforeach ?>
    </tr>
  <?php endforeach ?>
</table>
</div>
<?php //echo link_to_if(isset($prev_month), __(date('F', strtotime($next_month))).' >>' , 'admin/commentsCalendar?date='.$next_month) ?>
