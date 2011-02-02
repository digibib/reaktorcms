<?php
/**
  * This file defines the user report panel
  * 
  * Takes parameters:
  * $residences
  * $interests
  * $report_types
  * 
  */

use_helper('Javascript', 'wai');
reaktor::setReaktorTitle(__('User reports'));

?>

<?php include_component("reports", "savedReportsFloatBox", array("type" => "user")); ?>

<div style="<?php if ($sf_params->get("execute")) echo 'display: none;'; ?>" id="query_generator">
  <h1><?php echo __('Generate custom user report'); ?></h1>
  <p><?php echo __('Check the boxes you want to include in your report, select a report type then click the "Generate report" button'); ?></p>
  <h2><?php echo link_to_function('Toggle User reports and activity reports',
                 visual_effect('toggle_blind', 'user_report_form').visual_effect('toggle_blind', 'user_activity_report')); ?></h2>
  <br />
  <div id = "user_report_form" <?php if ($sf_params->get("execute") == "activityReport") echo "style = 'display:none;'"; ?>>
    <?php echo form_tag("@userreports", array("method" => "get")); ?>
      <fieldset>
        <div class="user_report_text">
          <?php echo checkbox_tag('residence_check', '1', $sf_params->get("residence_check")); ?>
          <?php echo wai_label_for('residence', __('Residence:')); ?>
        </div>  
        <?php // echo select_tag('residence', options_for_select($residences, $sf_params->get("residence"))); ?>

  <?php
  
      $residence_array = ResidencePeer::getResidenceLevel();

   echo select_tag('residence', options_for_select($residence_array, $sf_params->get("residence"), array(    
    'include_custom' => __('Choose a residence'),
  ))); ?>
        <br />
        
        <div class="user_report_text">
          <?php echo checkbox_tag('interest_check', '1', $sf_params->get("interest_check")); ?>
          <?php echo wai_label_for('interest', __('Interest:')); ?>
        </div>
        <?php echo select_tag('interest', options_for_select($interests, $sf_params->get("interest"))); ?>
        <br />
        
        <div class="user_report_text">
          <?php echo checkbox_tag('sex_check', '1', $sf_params->get("sex_check")); ?>
          <?php echo wai_label_for('sex', __('Sex:')); ?>
        </div>
        <?php echo select_tag('sex', options_for_select(array(1 =>__('Male'), 2 =>__('Female')), $sf_params->get("sex"))); ?>
        <br />
        
        <div class="user_report_text">
          <?php echo checkbox_tag('startDateArr_check', '1', $sf_params->get("startDateArr_check"), array("onclick" => "$('current_month_check').checked=false;")); ?>
          <?php echo wai_label_for('startDateArr', __('Registered after:')); ?>
        </div>
        <?php echo input_date_tag('startDateArr', $sf_params->get("startDateArr", ""), array(
                      'rich'           => false, 
                      'culture'        => $sf_user->getCulture(),  
                      'year_end'       => date('Y')-sfConfig::get('app_profile_max_age',100),
                      'year_start'     => date('Y'),
                      'date_seperator' => ' ',
                      'onblur'         => "$('information_msg').innerHTML='".__('**help-text when no field is selected**')."'",
                      'onfocus'        => "$('information_msg').innerHTML='".__('**help-text for date of birth**')."'",
                      'include_custom' => array('day'=>__('Day'), 'month'=>__('Month'), 'year'=>__('Year')),
        )); ?>
        <br />
        
        <div class="user_report_text">
          <?php echo checkbox_tag('endDateArr_check', '1', $sf_params->get("endDateArr_check"), array("onclick" => "$('current_month_check').checked=false;")); ?>
          <?php echo wai_label_for('endDateArr', __('Registered before:')); ?>
        </div>  
        <?php echo input_date_tag('endDateArr', $sf_params->get("endDateArr", ""), array(
                    'rich'           => false, 
                    'culture'        => $sf_user->getCulture(),  
                    'year_end'       => date('Y')-sfConfig::get('app_profile_max_age',100),
                    'year_start'     => date('Y'),
                    'date_seperator' => ' ',
                    'onblur'         => "$('information_msg').innerHTML='".__('**help-text when no field is selected**')."'",
                    'onfocus'        => "$('information_msg').innerHTML='".__('**help-text for date of birth**')."'",
                    'include_custom' => array('day'=>__('Day'), 'month'=>__('Month'), 'year'=>__('Year'))
        )); ?>
        <br />

        <br class = "clearboth" />
        <div class="user_report_text">
          <?php echo checkbox_tag('activated_check', 1, $sf_params->get("activated_check"), array('id' => 'voted')); ?>
          <?php echo wai_label_for('activated', __('Activated'), array('class' => 'inline')); ?>
        </div>
        <?php echo select_tag('activatedYesNo',options_for_select(array("no", "yes"), $sf_params->get("activatedYesNo"))); ?>
        <br class = "clearboth"/>

        <div class="user_report_text">
          <?php echo checkbox_tag('verified_check', 1, $sf_params->get("verified_check"), array('id' => 'verified')); ?>
          <?php echo wai_label_for('verified', __('Verified'), array('class' => 'inline')); ?>
        </div>
        <?php echo select_tag('verifiedYesNo',options_for_select(array("no", "yes"), $sf_params->get("verifiedYesNo"))); ?>


        <br class = "clearboth"/>
        <div class="user_report_text">
          <?php echo checkbox_tag('showContent_check', 1, $sf_params->get("showContent_check"), array('id' => 'showContent')); ?>
          <?php echo wai_label_for('showContent', __('Show this users content'), array('class' => 'inline')); ?>
        </div>
        <?php echo select_tag('showContentYesNo',options_for_select(array("no", "yes"), $sf_params->get("showContentYesNo"))); ?>
        <br />  <br />

        <div class="user_report_text">  
          <?php echo checkbox_tag('current_month_check', '1', $sf_params->get("current_month_check"), 
                     array("onclick" => "$('endDateArr_check').checked=false;$('startDateArr_check').checked=false;")); ?>
          <?php echo wai_label_for("current_month_check", __('Registered this month')); ?>
        </div>
        <br class = "clearboth"/><br />
        
        <div class="user_report_text">
          <?php echo checkbox_tag('publishedArtwork', 1, $sf_params->get("publishedArtwork"), 
                     array('id' => 'publishedArtwork', 'onclick' => '$("notPublishedArtwork").checked = false;')); ?>
          <?php echo wai_label_for('publishedArtwork', __('Has published artwork')); ?> 
        </div>           
        <br class = "clearboth"/>
        
        <div class="user_report_text">
          <?php echo checkbox_tag('notPublishedArtwork', 1, $sf_params->get("notPublishedArtwork"), 
                   array('id' => 'notPublishedArtwork', 'onclick' => '$("publishedArtwork").checked = false;')); ?>
          <?php echo wai_label_for('notPublishedArtwork', __('Not published artwork')); ?>
        </div>
        <br class = "clearboth"/><br />
        
        <?php echo select_tag('commentAndOr', options_for_select(array("or", "and"), $sf_params->get("commentAndOr"))); ?>
        <br class = "clearboth" />
        <div class="user_report_text">
          <?php echo checkbox_tag('commentedArtwork', 1, $sf_params->get("commentedArtwork"), 
                   array('id' => 'commentedArtwork', 'onclick' => '$("notCommentedArtwork").checked = false;')); ?>
          <?php echo wai_label_for('commentedArtwork', __('Has commented'), array('class' => 'inline')); ?>
        </div>
        <br class = "clearboth"/>
        
        <div class="user_report_text">
          <?php echo checkbox_tag('notCommentedArtwork', 1, $sf_params->get("notCommentedArtwork"), 
                   array('id' => 'notCommentedArtwork', 'onclick' => '$("commentedArtwork").checked = false;')); ?>
          <?php echo wai_label_for('notCommentedArtwork', __('Has not commented'), array('class' => 'inline')); ?> 
        </div>
        
        <br /><br />        
        
        <?php echo select_tag('voteAndOr',options_for_select(array("or", "and"), $sf_params->get("voteAndOr"))); ?>
        <br class = "clearboth" />
        <div class="user_report_text">
          <?php echo checkbox_tag('voted', 1, $sf_params->get("voted"), 
                     array('id' => 'voted', 'onclick' => '$("notVoted").checked = false;')); ?>
          <?php echo wai_label_for('voted', __('Has voted'), array('class' => 'inline')); ?> 
        </div>
        <br class = "clearboth"/>
        
        <div class="user_report_text">
          <?php echo checkbox_tag('notVoted', 1, $sf_params->get("notVoted"), 
                     array('id' => 'notVoted', 'onclick' => '$("voted").checked = false;')); ?>
          <?php echo wai_label_for('notVoted', __('Has not voted'), array('class' => 'inline')); ?> 
        </div>
        
        <br />  <br />
 
        <div>
          <?php echo wai_label_for('report_type', __('Report type')); ?>
        </div>
        <?php echo select_tag('report_type', options_for_select(array('1' => __('Statistics'), '2' => __('User list')), $sf_params->get("report_type"))); ?>
        <?php echo submit_tag(__('Generate report')); ?>
      </fieldset>
      <?php echo input_hidden_tag("execute", "userReport"); ?>
    </form>
    <br />
  </div>
  
  <div class="user_activity_report" id="user_activity_report" <?php if ($sf_params->get("execute") != "activityReport") echo "style = 'display:none;'"; ?>>
    <?php echo form_tag("@userreports", array("method" => "get")); ?>
      
      <div>
        <?php echo wai_label_for('reporType', __("Report:")); ?>
      </div>
      <?php echo select_tag('reportType', options_for_select($report_types, $sf_params->get("reportType"))); ?>
      <br />
      
      <div>
        <?php echo wai_label_for('subreaktor', __('subReaktor')); ?>
      </div>  
      <?php echo select_tag('subreaktor', options_for_select($interests, $sf_params->get("subreaktor"))); ?>
      <br />
      
      <div>
        <?php echo wai_label_for('sex', __('Sex')); ?>
      </div>
      <?php echo select_tag('sex', options_for_select(array(0 => __('Both'), 1 => __('Male'), 2 => __('Female')), $sf_params->get("sex"))); ?>
      <br />
      
      <div>
        <?php echo wai_label_for('startActivityDate', __("Activity after:")); ?>
      </div>
      <?php echo input_date_tag('startActivityDate', $sf_params->get("startActivityDate", ""), array(
        'rich'           => false, 
        'culture'        => $sf_user->getCulture(),  
        'year_end'       => date('Y')-sfConfig::get('app_profile_max_age',100), 
        'year_start'     => date('Y'),
        'date_seperator' => ' ',
        'onblur'         => "$('information_msg').innerHTML='".__('**help-text when no field is selected**')."'",
        'onfocus'        => "$('information_msg').innerHTML='".__('**help-text for date of birth**')."'",
        'include_custom' => array('day'=>__('Day'), 'month'=>__('Month'), 'year'=>__('Year'))
      ))?>
      <br />
      
      <div>
        <?php echo wai_label_for('endActivityDate', __('Activity before:')); ?>
      </div>
      <?php 
        echo input_date_tag('endActivityDate', $sf_params->get("endActivityDate", ""), array(
        'rich'           => false, 
        'culture'        => $sf_user->getCulture(),  
        'year_end'       => date('Y')-sfConfig::get('app_profile_max_age',100), 
        'year_start'     => date('Y'),
        'date_seperator' => ' ',
        'onblur'         => "$('information_msg').innerHTML='".__('**help-text when no field is selected**')."'",
        'onfocus'        => "$('information_msg').innerHTML='".__('**help-text for date of birth**')."'",
        'include_custom' => array('day'=>__('Day'), 'month'=>__('Month'), 'year'=>__('Year'))
      )); ?>
      <br />
      <div class = "full_width">  
          <?php echo checkbox_tag('current_month_activity_check', '1', $sf_params->get("current_month_activity_check"), 
                     array("onclick" => "$('endActivityDate_check').checked=false;$('startActivity_check').checked=false;")); ?>
          <?php echo wai_label_for("current_month_activity_check", __('Active this month (overrides date selection above)')); ?>
      </div>
      <br /><br />
        
      <?php echo submit_tag(__('Generate report')); ?>
      <?php echo input_hidden_tag("execute", "activityReport"); ?>
    </form>
  </div>
</div>
 
<?php if ($sf_params->get("execute")): ?>
  <div id = "query_show_hide">
    <?php echo link_to_function(__('Show / hide query generator'), "$('query_generator').toggle();"); ?>
  </div>
  <div class = "results_block">
    <h1><?php echo __('Results') ?>:</h1>
    <?php if ($sf_params->get("execute") == "userReport"): ?>
      <?php include_partial("userReportsQuery", array("resultset" => $resultset)); ?>
    <?php elseif ($sf_params->get("execute") == "activityReport"): ?>
      <?php include_partial("userActivityReportsQuery", array("res" => $res)); ?>
    <?php endif; ?>
   </div>
<?php endif; ?>
