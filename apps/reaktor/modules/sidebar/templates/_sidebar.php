<?php
/**
 * The layout of the reaktor page includes a footer, a header, the main content and a sidebar. The sidebar
 * is the right hand bar on every page which has login and user information, links, the messages box etc.
 * This is the template for the sidebar, and its component is called only once, and that's from layout.php:
 * 
 * include_component('sidebar', 'sidebar')
 * 
 * Since its included in the layout, it is displayed on every single reaktor page, and the content of it will
 * change according to which page is loaded, if the user is logged in, and if he/she has administration 
 * credentials. 
 * 
 * The caller of the sidebar component do not have to pass any parameters.
 * 
 * The controller passes the following information:
 *  - $artwork_count : The number of approved artworks on the reaktor site 
 *  - $articles      : The articles that should be listed in the sidebar, this is changes according to the page
 *  
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @author    June Henriksen <juneih@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

?>
<div id="sidebar_stats">
  <p class="nomargin">
    <?php echo __("Artwork count: %artwork_count%", array("%artwork_count%" => $artwork_count)); ?> <br />
    <?php echo __("Online now: %online_count%", array("%online_count%" => $user_count)); ?> 
  </p>
</div>

<?php if ($sf_params->get('module') == 'profile' && $sf_params->get('action') == 'portfolio'): ?>
  <?php include_component("profile","portfolioUserinfo"); ?>
  <br />
<?php endif; ?>

<?php if (!$sf_user->isAuthenticated()): ?>
  <?php include_partial("sidebar/login"); ?>
<?php elseif ($sf_user->hasCredential('staff')): ?>
  <?php include_component("admin", "adminSummary"); ?> 
  <?php include_partial("messaging/messagesWrapper"); ?>
<?php else: ?>
  <?php include_partial("sidebar/user_summary"); ?>
  <?php include_partial("messaging/messagesWrapper"); ?>
<?php endif; ?>  

<?php include_component('adminmessage', 'nextMessageDueToExpire'); ?>

<?php if (!$sf_user->hasCredential('staff')): ?>	
	<?php include_partial('sidebar/send_in'); ?>
<?php elseif (isset($internal_articles) && $internal_articles): ?>
  <div id="internal_articles">
    <?php include_partial('articles/articleList', array('articles' => $internal_articles)); ?>
  </div> 
<?php endif; ?>

<?php include_component_slot('sidebar_articles'); //sidebar articles (rss feed or reaktor articles)?>

<?php include_component('tags', 'tagSearchBox'); ?>
<br />
<div id="showuserlist"><p><?php echo reaktor_link_to(__('Show all users'), '@userlist'); ?></p></div>
