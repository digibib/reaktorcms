<?php
/**
 * Admin menu bar partial
 * This partial is included in the main page header and shows the admin menu options instead of the usual site menu
 * The decision whether this menu is displayed is taken elsewhere (in the including template) however, each of the
 * individual admin menu items will only be shown to users with appropriate credentials
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
?>
<div id="menu_bar">
  <?php if ($sf_user->hasCredential('viewallcontent') || $sf_user->hasCredential('discussartwork') || $sf_user->hasCredential('approveartwork') || $sf_user->hasCredential("createcompositeartwork")): ?>
	  <div class="dropdown_menu_link">
	  	<a href="#" onmouseout="Element.hide('admin_artworks_menu');" onmouseover="Element.show('admin_artworks_menu');" class="dropdown_menu_link_container"><?php echo __('Artworks') ?></a>
	  	<br />
	    <div style="display: none;" class="dropdown_menu normal" id="admin_artworks_menu" onmouseout="Element.hide('admin_artworks_menu');" onmouseover="Element.show('admin_artworks_menu');">
	    <ul>
	      <?php if ($sf_user->hasCredential('viewallcontent')): ?>
	        <li><?php echo link_to(__('Approved artworks'), '@approvedartwork'); ?> </li>
	        <li><?php echo link_to(__('Unapproved artworks'), '@unapproved_listmyteams'); ?> </li>
		      <li><?php echo link_to(__('Rejected artworks'), '@listrejected'); ?> </li>
	        <li><?php echo link_to(__('Modified artworks'), '@artworkslistmodified'); ?></li>
	        
	      <?php endif; ?>
	      <?php if ($sf_user->hasCredential('discussartwork')): ?>
	        <li><?php echo link_to(__('Under discussion'), '@listdiscussion'); ?> </li>
	        <li><hr class="menu_separator"/></li>
	      <?php endif; ?>
	      
	      <?php if ($sf_user->hasCredential('approveartwork')): ?>
	       <li><?php echo link_to(__('Unapproved artworks in other editorial centers'), '@unapproved_listotherteams') ?></li>
	      <?php endif ?>
	      <?php if ($sf_user->hasCredential("createcompositeartwork")): ?>
	      	<li><?php echo link_to(__('Create composite artwork'), '@createcompositeartwork'); ?> </li>
	      	<li><?php echo link_to(__('List composite artworks'), '@listcompositeartwork'); ?> </li>
	      	<li><hr class="menu_separator"/></li>
	     	<?php endif; ?>
	     	<?php if ($sf_user->hasCredential('approveartwork')): ?>
	        <li><?php echo link_to(__('List reported files'), '@listreportedcontent'); ?> </li>
	        <li><?php echo link_to(__('List unsuitable files'), '@listrejectedfiles'); ?> </li>
	        <li><?php echo link_to(__('Recommended artworks across the site'), '@listrecommended'); ?> </li>
	        <li><?php echo link_to(__('Artwork reject template preferences'), '@rejectiontypes'); ?> </li>
	      <?php endif; ?>
	      
	    </ul>
	    </div>
	  </div>
	<?php endif; ?>
  <?php if ($sf_user->hasCredential('tagadministrator')): ?>
	  <div class="dropdown_menu_link">
	  	<a href="#" onmouseout="Element.hide('admin_tags_menu');" onmouseover="Element.show('admin_tags_menu');" class="dropdown_menu_link_container"><?php echo __('Tags') ?></a>
	  	<br />
	    <div style="display: none;" class="dropdown_menu narrow" id="admin_tags_menu" onmouseout="Element.hide('admin_tags_menu');" onmouseover="Element.show('admin_tags_menu');">
	      <ul>
          <li><?php echo link_to(__('List all'), '@taglist'); ?> </li>
          <li><?php echo link_to(__('List unapproved'), '@taglist_unapproved?page=ALL'); ?> </li>
	      </ul>
	    </div>
	  </div>
  <?php endif; ?>
  <?php if ($sf_user->hasCredential('commentadmin')): ?>
	  <div class="dropdown_menu_link">
	  	<a href="#" onmouseout="Element.hide('admin_comments_menu');" onmouseover="Element.show('admin_comments_menu');" class="dropdown_menu_link_container"><?php echo __('Comments') ?></a>
	  	<br />
	    <div style="display: none;" class="dropdown_menu wide" id="admin_comments_menu" onmouseout="Element.hide('admin_comments_menu');" onmouseover="Element.show('admin_comments_menu');">
	      <ul>
	        <li><?php echo link_to(__('Comments calendar'), '@commentscalendar'); ?> </li>
		      <li><?php echo link_to(__('New reported comments'), '@reportedcomments')?> </li> 
		      <li><?php echo link_to(__('Unsuitable comments'), '@unsuitablecomments')?> </li>
	      </ul>
	    </div>
	  </div>
  <?php endif; ?>
  <?php $perm = ArticlePeer::getArticleTypesByPermission($sf_user);
  if (count($perm)):?>
	  <div class="dropdown_menu_link"><a href="#" onmouseout="Element.hide('admin_articles_menu');" onmouseover="Element.show('admin_articles_menu');" class="dropdown_menu_link_container"><?php echo __('Articles') ?></a><br />
	    <div style="display: none;" class="dropdown_menu narrow" id="admin_articles_menu" onmouseout="Element.hide('admin_articles_menu');" onmouseover="Element.show('admin_articles_menu');">
	    <ul>
	      <li><?php echo link_to(__('Compose article'), '@createarticle?editing=yes'); ?> </li>
	      <li><?php echo link_to(__('View all'), '@listarticles?status=all'); ?> </li>
	      <li><?php echo link_to(__('Order articles'), '@orderarticles'); ?> </li>
	      <li><hr class="menu_separator"/></li>
	      <li><?php echo link_to(__('Drafts'), '@listarticles?status=draft') ?></li>
	      <li><?php echo link_to(__('Published'), '@listarticles?status=published') ?></li>
	      <li><?php echo link_to(__('Archived'), '@listarticles?status=archived') ?></li>
	      <li><hr class="menu_separator"/></li>
	      <?php if ($sf_user->hasCredential('createhelparticle')): ?>
	        <li><?php echo link_to(__('Help articles'), "@listarticles?article_type=".ArticlePeer::HELP_ARTICLE); ?></li>
	      <?php endif; ?>
	      <?php if ($sf_user->hasCredential('createthemearticle')): ?>
	        <li><?php echo link_to(__('Theme articles'), "@listarticles?article_type=".ArticlePeer::THEME_ARTICLE); ?></li>
	      <?php endif; ?>
	      <?php if ($sf_user->hasCredential('createinternalarticle')): ?>
	        <li><?php echo link_to(__('Internal articles'), "@listarticles?article_type=".ArticlePeer::INTERNAL_ARTICLE); ?></li>
	      <?php endif; ?>
	      <?php if ($sf_user->hasCredential('createfooterarticle')): ?>
	        <li><?php echo link_to(__('Footer articles'), "@listarticles?article_type=".ArticlePeer::FOOTER_ARTICLE); ?></li>
	      <?php endif; ?>
	      <?php if ($sf_user->hasCredential('createmypagearticle')): ?>
	        <li><?php echo link_to(__('My page articles'), "@listarticles?article_type=".ArticlePeer::MY_PAGE_ARTICLE); ?></li>
	      <?php endif; ?>
	      <?php if ($sf_user->hasCredential('createregulararticle')): ?>
	        <li><?php echo link_to(__('Regular articles'), "@listarticles?article_type=".ArticlePeer::REGULAR_ARTICLE); ?></li>
	      <?php endif; ?>
	      <?php if ($sf_user->hasCredential('createspecialarticle')): ?>
	        <li><?php echo link_to(__('Special articles'), "@listarticles?article_type=".ArticlePeer::SPECIAL_ARTICLE); ?></li>
	      <?php endif; ?>
	    </ul>
	    </div>
	  </div>
	<?php endif; ?>
  <?php if ($sf_user->hasCredential('listuser')||$sf_user->hasCredential('listgroup')||$sf_user->hasCredential('listpermission')||$sf_user->hasCredential('edituser')): ?>
    <div class="dropdown_menu_link"><a href="#" onmouseout="Element.hide('admin_users_menu');" onmouseover="Element.show('admin_users_menu');" class="dropdown_menu_link_container"><?php echo __('User administration') ?></a><br />
      <div style="display: none;" class="dropdown_menu normal" id="admin_users_menu" onmouseout="Element.hide('admin_users_menu');" onmouseover="Element.show('admin_users_menu');">
        <ul>
          <?php if ($sf_user->hasCredential('listuser')||$sf_user->hasCredential('listgroup')||$sf_user->hasCredential('listpermission')): ?>
            <li><?php echo link_to(__('List users'), '@listusers'); ?> </li>
            <li><?php echo link_to(__('List most ignored users'), '@listignoredusers'); ?> </li>
            <?php if ($sf_user->hasCredential('listgroup') || $sf_user->hasCredential('listpermission') || $sf_user->hasCredential('edituser')): ?>
            <li><?php echo link_to(__('Online users'), "admin/onlineNow"); ?></li>
            	<li><hr class="menu_separator"/></li>
          	<?php endif; ?>
          <?php endif; ?>
          <?php if ($sf_user->hasCredential('listgroup')): ?>
            <li><?php echo link_to(__('List user groups'), '@listgroups?filters[is_editorial_team]=0&filter=filter'); ?> </li>
            <li><?php echo link_to(__('List editorial teams'), '@listgroups?filters[is_editorial_team]=1&filter=filter'); ?> </li>
          <?php endif; ?>
          <?php if ($sf_user->hasCredential('listpermission')): ?>
            <li><?php echo link_to(__('List permissions'), '@listpermissions'); ?> </li>
            <?php if ($sf_user->hasCredential('edituser')): ?>
              <li><hr class="menu_separator"/></li>
            <?php endif; ?>
          <?php endif; ?>
          <?php if ($sf_user->hasCredential('edituser')): ?>
            <li><?php echo link_to(__('Create new user'), '@createuser'); ?> </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  <?php endif ?>
  <?php if ($sf_user->hasCredential('viewreports') || $sf_user->hasCredential('phpmyadmin')): ?>
    <div class="dropdown_menu_link"><a href="#" onmouseout="Element.hide('admin_statistics_menu');" onmouseover="Element.show('admin_statistics_menu');" class="dropdown_menu_link_container"><?php echo __('Statistics and reports') ?></a><br />
      <div style="display: none;" class="dropdown_menu normal" id="admin_statistics_menu" onmouseout="Element.hide('admin_statistics_menu');" onmouseover="Element.show('admin_statistics_menu');">
      <ul>
	      <?php if ($sf_user->hasCredential('viewreports')): ?>
	        <li><?php echo link_to(__('Artwork reports'), '@artworkreports'); ?> </li>
	        <li><?php echo link_to(__('User reports'), '@userreports'); ?> </li>
	        <li><?php echo link_to(__('Most Active users'), '@most_active'); ?> </li>
	        <li><?php echo link_to(__('Bookmarked reports'), '@showReportBookmarks'); ?></li>
	        <li><hr class="menu_separator"/></li>
	      <?php endif ?> 
	      <?php if($sf_user->hasCredential('phpmyadmin')): ?>
	        <li><?php echo link_to(__('Go to PHPMyAdmin'), '@pma') ?></li>
	      <?php endif ?>
        <li><?php echo link_to(__('Google Analytics'), "http://www.google.com/analytics/"); ?></li>
        <li><?php echo link_to(__('Webalizer'), "http://".$sf_request->getHost()."/webalizer"); ?></li>
      </ul>      
    </div>
  </div>
  <?php endif ?> 
  <?php if ($sf_user->hasCredential('translator')): ?>
	  <div class="dropdown_menu_link"><a href="#" onmouseout="Element.hide('admin_translation_menu');" onmouseover="Element.show('admin_translation_menu');" class="dropdown_menu_link_container"><?php echo __('Translation') ?></a><br />
	    <div style="display: none;" class="dropdown_menu normal" id="admin_translation_menu" onmouseout="Element.hide('admin_translation_menu');" onmouseover="Element.show('admin_translation_menu');">
	    <ul>
	      <li><?php echo link_to(__('Website text'), '@trans_list'); ?> </li>
	      <li><?php echo link_to(__('Artwork status descriptions'), '@artworkstatuses'); ?> </li>
	      <li><?php echo link_to(__('subReaktor names'), '@subreaktornames'); ?> </li>
	      <li><?php echo link_to(__('Categories'), '@listcategories'); ?> </li>
        <li><?php echo link_to(__('Permission descriptions'), '@sfguardpermissiondescriptionlist'); ?> </li>
		  </ul>
	    </div>
	  </div>
  <?php endif; ?>
  
   <div class="dropdown_menu_link"><a href="#" onmouseout="Element.hide('admin_other_menu');" onmouseover="Element.show('admin_other_menu');" class="dropdown_menu_link_container"><?php echo __('Other') ?></a><br />
    <div style="display: none;" class="dropdown_menu normal" id="admin_other_menu" onmouseout="Element.hide('admin_other_menu');" onmouseover="Element.show('admin_other_menu');">
    <ul>
      <?php if ($sf_user->hasCredential('subreaktoradministrator')): ?>
        <li><?php echo link_to(__('Administration subReaktors'), '@listsubreaktors'); ?> </li>
      <?php endif; ?>      
      <?php if ($sf_user->hasCredential('listoptinuseremails')): ?> 
      <li><?php echo link_to(__('List opt-in user e-mails'), '@listoptinusers'); ?></li>      
      <?php endif; ?>      
      <?php if ($sf_user->hasCredential('adminmessages')): ?> 
        <li><?php echo link_to(__('List and create admin messages'), '@adminmessage'); ?> </li>        
      <?php endif; ?> 
      <?php if ($sf_user->hasCredential('managenotifications')): ?> 
        <li><?php echo link_to(__('New artwork notification'), '@listmyteams'); ?> </li>        
      <?php endif; ?>
      <?php if ($sf_user->hasCredential('listresidences')): ?>
        <li><?php  echo link_to(__('Residences'), '@residences'); ?></li>
      <?php endif ?>
      <?php if ($sf_user->hasCredential('adminfunctions')): ?>
        <li><?php echo link_to(__('Admin functions'), '@admin_functions?mode=index'); ?></li>
      <?php endif ?>
    </ul>
    </div>
  </div>
  <div id="lokalreaktor_link">
      <?php echo link_to(__('Reaktor frontpage'), '@home'); ?>
  </div>
</div>
