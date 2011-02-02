<?php
/**
 * Artwork report page
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

use_helper('Javascript', 'seconds', 'wai');
reaktor::setReaktorTitle(__('Artwork reports'));

?>

<?php include_component("reports", "savedReportsFloatBox", array("type" => "artwork")); ?>
  <div style="<?php if ($report_type != '') echo 'display: none;'; ?>" id="query_generator">
    
    <h1><?php echo __('Generate new artwork report') ?></h1>
    <p><?php echo __('Check the boxes you want to include in your report, select a report type then click the "Generate report" button'); ?></p>
    <h3><?php echo __('Generate a report of all artwork with the following criteria'); ?></h3>
  
    <?php echo form_tag('@artworkreports', array("method" => "get")); ?>
      <fieldset>
        <div>
          <?php echo checkbox_tag('subreaktor_check', '1', $subreaktor_check); ?>
          <?php echo wai_label_for('subreaktor_check', __('subReaktor')); ?>
        </div>
        <?php echo select_tag('subreaktor_id', options_for_select(Subreaktor::getAllAsIndexedArray(), $subreaktor_id)); ?>
        <br />
        <div>
          <?php echo checkbox_tag('category_check', '1', $category_check); ?>
          <?php echo wai_label_for('category_check', __('Category')); ?>
        </div>
        <?php echo select_tag('category_id', options_for_select(CategoryPeer::getAllAsIndexedArray(), $category_id)); ?>
        <br class="clearboth"/>
        <div>
          <?php echo checkbox_tag('tags_check', '1', $tags_check); ?>
          <?php echo wai_label_for("tags_check", __('Tag(s)')); ?>
        </div>
        <?php echo input_tag('tags', $tags); ?><br />
        <div>
          <?php echo checkbox_tag('editorial_team_check', '1', $editorial_team_check); ?>
          <?php echo wai_label_for("editorial_team_check", __('Editorial team')); ?>
        </div>
        <?php echo select_tag('editorial_team_id', options_for_select(sfGuardGroupPeer::getEditorialTeamsAsIndexedArray(), $editorial_team_id)) ?>
        <br />
        <div>
          <?php echo checkbox_tag('editorial_team_member_check', '1', $editorial_team_member_check); ?>
          <?php echo wai_label_for("editorial_team_member_check", __('Editorial team member')); ?>
        </div>
        <?php echo select_tag('editorial_team_member_id', options_for_select(sfGuardUserGroupPeer::getMembersofEditorialTeams(), $editorial_team_member_id)); ?>
        <br class="clearboth"/>
        <div>
          <?php echo checkbox_tag('status_check', '1', $status_check); ?>
          <?php echo wai_label_for("status_check", __('Status')); ?>
        </div>
        <?php echo select_tag('status_value', options_for_select(array('2' => __('Awaiting approval'), '3' => __('Approved'), '4' => __('Rejected'), '5' => __('Removed')), $status_value)); ?>
        <br />
        <?php echo checkbox_tag('under_discussion_check', '1', $under_discussion_check); ?>
        <?php echo wai_label_for("under_discussion_check", __('Is under discussion')); ?>
        <br />
        <div>
          <?php echo checkbox_tag('from_date_check', '1', $sf_params->get('from_date_check'), array("onclick" => "$('current_month_check').checked=false;")); ?>
          <?php echo wai_label_for("from_date_check", __('From date')); ?>
        </div>
      	<?php echo input_date_tag('from_date', $from_date, array(
                          	  'rich'           => false, 
                          	  'culture'        => $sf_user->getCulture(),  
                          	  'year_end'       => date('Y'), 
                          	  'year_start'     => 2004,
                          	  'date_seperator' => ' ',
                          	  'include_custom' => array('day'=>__('Day'), 'month'=>__('Month'), 'year'=>__('Year'))
      	)); ?>
      	<br />
        
        <div>
          <?php echo checkbox_tag('to_date_check', '1', $sf_params->get('to_date_check'), array("onclick" => "$('current_month_check').checked=false;")); ?>
          <?php echo wai_label_for("to_date_check", __('To date')); ?>
        </div>
        
        <?php echo input_date_tag('to_date', $to_date, array(
                              'rich'           => false, 
                              'culture'        => $sf_user->getCulture(),  
                              'year_end'       => date('Y'), 
                              'year_start'     => 2004,
                              'date_seperator' => ' ',
                              'include_custom' => array('day'=>__('Day'), 'month'=>__('Month'), 'year'=>__('Year'))
        )); ?>
        <br />
        <div>  
          <?php echo checkbox_tag('current_month_check', '1', $sf_params->get("current_month_check"), 
                     array("onclick" => "$('to_date_check').checked=false;$('from_date_check').checked=false;")); ?>
          <?php echo wai_label_for("current_month_check", __('Current month')); ?>
        </div>
        <br /><br />
        
        <div>
          <?php echo wai_label_for('report_type', __('Report type')); ?>
        </div>
          <?php echo select_tag('report_type', options_for_select(array('1' => __('Statistics'), '2' => __('Artwork list')), $report_type)); ?>
          <?php echo submit_tag(__('Generate report')); ?>
      </fieldset>
    </form>
  </div>
    
  <?php if ($report_type != ''): ?>
    <div id = "query_show_hide">
      <?php echo link_to_function(__('Show / hide query generator'), "$('query_generator').toggle();"); ?>
    </div>
  	<div id = "query_results">
      <?php if ($report_type == 1): ?>
    	  <h2><?php echo __('Number of artworks'); ?></h2>
    	  <?php echo __('%number_of_artworks% unique artworks matching your query', array('%number_of_artworks%' => $num_artworks)); ?>
        <?php if ($num_artworks > 1): ?>
    	    <h2><?php echo __('Average waiting time before approval'); ?></h2>
    	    <?php $avg_time = format_duration($diff); ?>
    	    <?php echo __('%weeks% week(s), %days% day(s), %hours% hour(s)', array('%weeks%' => $avg_time['weeks'], '%days%' => $avg_time['days'], '%hours%' => $avg_time['hours'])); ?>
        <?php endif; ?>
    	<?php elseif ($report_type == 2): ?>
        <h2><?php echo __('Artwork matching your query') ?></h2>
        <ul>
    	  <?php foreach ($artworks as $artwork): ?>
          <li>
      	    <?php $displayname = ((!$artwork->getUser()->getNamePrivate())&&($artwork->getUser()->getName() != '')) ? $artwork->getUser()->getName() : $artwork->getUser()->getUsername(); ?> 
            <?php echo __('%artwork_title% by %username%', 
                  array('%artwork_title%' => '<b>' . link_to($artwork->getTitle(), $artwork->getLink()) . '</b>', 
                        '%username%' => '<b>' . reaktor_link_to($displayname, '@portfolio?user=' . $artwork->getUser()->getUsername()) . '</b>')); ?>
          </li> 
        <?php endforeach; ?>
        </ul>
    	<?php endif; ?>
    </div>
  <?php endif; ?>
