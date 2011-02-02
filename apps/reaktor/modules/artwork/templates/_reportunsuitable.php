<?php
/**
 * Helper to add a "report unsuitable content" link
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @author    June Henriksen <juneih@linpro.no>
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
  
//Logged in users 
if($sf_user->isAuthenticated()):
use_helper("reportHistory");
 
  //Admin user
  if($sf_user->hasCredential("editusercontent")): 
?>

    <div class = "admin_message">
      <?php $reportHistory = $thefile->getReportHistory(); ?>
      <?php $reportUser    = !empty($reportHistory) ? current($reportHistory)->getSfGuardUser() : null; ?>
      <?php $reportDate    = !empty($reportHistory) ? date("d/m/Y H:i", strtotime(current($reportHistory)->getCreatedAt())) : ""; ?>
      <?php echo format_number_choice(
        "[0]This content has not been reported|"
        ."[1]This content was reported by %username% on %reportdate%|"
        ."[1,+Inf]This content was reported by %username% on %reportdate% "
        ."and by %mouseoveruserlist% in total", 
         array("%username%" => is_object($reportUser) ? $reportUser->getUsername() : "",
         			"%reportdate%" => $reportDate,
               "%mouseoveruserlist%" => link_to(__("%reportedcount% users", array("%reportedcount%" => count($reportHistory))), "#",
               array("onmouseover" => "Tip('".displayReportHistory($reportHistory)."');",
                     "onmouseout" => "UnTip();"))), 
         count($reportHistory)); ?>
       <?php if ($thefile->isUnderDiscussion()): ?>
         <br /><?php echo __('This file is under discussion [ %link_to_view% ]', array('%link_to_view%' => reaktor_link_to(__('view'), '@show_discussion?id='.$thefile->getId().'&type=file'))) ?>
       <?php endif; ?>
       <?php if (isset($artwork) && $artwork->isUnderDiscussion()): ?>
         <br /><?php echo __('This file is under discussion [ %link_to_view% ]', array('%link_to_view%' => reaktor_link_to(__('view'), '@show_discussion?id='.$artwork->getId().'&type=artwork'))) ?>
       <?php endif; ?>
    </div>
    <div id='unsuitable_content_msg'> 
    </div>
    
  <?php //Non admin users
  else:      
    //User does not own the file
    if ($sf_user->getGuardUser()->getId() != $thefile->getUserId()): 
    
      //User has not reported the artwork before 
      if (!$sf_request->getCookie('reported_'.md5($sf_user->getGuardUser()->getUsername().$thefile->getId()))):?>
        <div id='unsuitable_content_msg'>
          <?php echo link_to_remote(__('Report unsuitable content'), array(
        	    'url'=>'@report_file?id=' . $artwork->getId() . '&title=' . $artwork->getTitle() . '&file=' . $thefile->getId(),
        	  	'update'=>'unsuitable_content_msg')) ?>
      	</div>
    <?php //User has reported the file
      else: ?>
        <div class = "admin_message">
          <?php echo __("You have reported this file, it will be reviewed by a staff member shortly"); ?>
        </div>
    <?php 
      endif; //endreported
      
    endif; //endowner
    
  endif; //endadmin
  
//Not logged in users 
else: 
  echo __('If you think this artwork is offensive, log in to report it.'); 
endif; //end logged in
?>
