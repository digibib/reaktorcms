<?php
/**
 * When a user with administration credentials log in, they will be redirected to this page. It provides
 * an overview over administration tasks, an acts as a portal to reaktor's backend. 
 * 
 * The controller/action passes the following information: 
 * 
 * Information on editorial teams 
 * - $editorialteams - which teams is the logged in user a member of
 * - $othereditorialteams - the rest of the teams
 * 
 * The following are integers with the amount of artworks/files/comments/tags in the respected areas
 * - $editorialteamartworks
 * - $othereditorialteamartworks
 * - $discussionFiles
 * - $discussionArtworks
 * - $reportedfiles
 * - $reportedcomments
 * - $unapprovedtags
 * 
 * PHP Version 5
 *
 * @author    Ole-Petter Wikene <olepw@linpro.no>
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

reaktor::setReaktorTitle(__('Admin portal')); 
$counter = 0;
?>
<br />
<?php if ($sf_user->hasCredential('approveartwork')): ?>
<?php $counter++ ?>
	<div class="admin_linkbar">
	    <div><?php echo link_to(__('Unapproved artworks in my editorial center'), '@unapproved_listmyteams'); ?>&nbsp;(<?php echo $editorialteamartworks ?>)</div>
	</div>
<?php endif; ?>
<?php if ($sf_user->hasCredential('viewothereditorialteams')): ?>
<?php $counter++ ?>
  <div class="admin_linkbar">
      <div><?php echo link_to(__('Unapproved artworks in other editorial centers'), '@unapproved_listotherteams'); ?>&nbsp;(<?php echo $othereditorialteamartworks ?>)</div>
  </div>
<?php endif; ?>
<?php if ($counter % 2): ?>
  <?php $counter++ ?>
  <div class="admin_linkbar">&nbsp;</div>
<?php endif; ?>
<br class="clearboth" />
<?php if ($sf_user->hasCredential('viewallcontent')): ?>
<?php $counter++ ?>
  <div class="admin_linkbar">
      <div><?php echo link_to(__('Content under discussion'), '@listdiscussion'); ?>&nbsp;(<?php echo $discussionFiles + $discussionArtworks; ?>)</div>
  </div>
<?php endif; ?>
<?php if ($sf_user->hasCredential('tagadministrator')): ?>
<?php $counter++ ?>
  <div class="admin_linkbar">
      <div><?php echo link_to(__('New, unapproved tags'), '@taglist_unapproved?page=ALL'); ?>&nbsp;(<?php echo $unapprovedtags ?>)</div>
  </div>
<?php endif; ?>
<?php if ($counter % 2): ?>
  <?php $counter++ ?>
  <div class="admin_linkbar">&nbsp;</div>
<?php endif; ?>
<br class="clearboth" />
<?php if ($sf_user->hasCredential('editusercontent') || $sf_user->hasCredential('viewallcontent')): ?>
<?php $counter++ ?>
  <div class="admin_linkbar">
      <div><?php echo link_to(__('Inappropriate content'), '@listreportedcontent'); ?>&nbsp;(<?php echo $reportedfiles ?>)</div>
  </div>
<?php endif; ?>
<?php if ($sf_user->hasCredential('commentadmin')): ?>
<?php $counter++ ?>
  <div class="admin_linkbar">
      <div><?php echo link_to(__('Inappropriate comments'), '@reportedcomments'); ?>&nbsp;(<?php echo $reportedcomments ?>)</div>
  </div>
<?php endif; ?>
<?php if ($counter % 2): ?>
  <?php $counter++ ?>
  <div class="admin_linkbar">&nbsp;</div>
<?php endif; ?>
<br class = "clearboth" />
<?php if ($sf_user->hasCredential('editusercontent') || $sf_user->hasCredential('viewallcontent')): ?>
<?php $counter++ ?>
  <div class="admin_linkbar">
      <div><?php echo link_to(__('Modified artworks'), '@artworkslistmodified'); ?>&nbsp;(<?php echo $modifiedartworks; ?>)</div>
  </div>
<?php endif; ?>
<?php if ($counter % 2): ?>
  <div class="admin_linkbar">&nbsp;</div>
<?php endif; ?>
  
<br class = "clearboth" />