<?php
/**
 * Display user information in sidebar on portfoliopage
 *
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
?>
<div id="user_info_portfolio">

	<?php if ($sf_user->hasCredential('editprofile')): ?>
    <div class="moderator_block">
	    <h2>Moderator:</h2><br />
	    <?php if (!$user->getShowContent()): // Warn moderator that this users artworks have been blocked for other users to see ?>
	      <h2><?php echo __("This user's content has been blocked") ?></h2><br />
	    <?php endif ?>
	    <?php echo link_to(__('Edit this user'),'@viewotherprofile?id='.$user->getId()) ?>
    </div>
	<?php endif; ?>
	
	<?php if($sf_user->isAuthenticated() && $user->getUsername() == $sf_user->getUsername() && !$user->getShowContent()): // User's viewing own page, and content is blocked ?>
	  <div class='user_warning'> 
	    <h3><?php echo __("Your artworks have been blocked for other users") ?></h3>
	  </div>
	  <br />
	<?php endif ?>
  <?php if (!$user->getNamePrivate() && $user->getName()): ?>
    <strong><?php echo __('Full name:'); ?></strong><br /><?php echo $user->getName(); ?><br />
  <?php endif; ?>
	<strong><?php echo __('Username:') ?></strong><br /><?php echo $user->getUsername() ?><br />
	<strong><?php echo __('Age:') ?></strong><br /><?php echo $user->getAge(); ?><br />
  <?php if ($user->getResidence() instanceof Residence): ?>
	  <strong><?php echo __('Residence:'); ?></strong><br /><?php echo $user->getResidence()->getName(); ?><br />
  <?php endif; ?>
	
	<?php if (count($interests) > 0): ?>
	  <h3><?php echo __('Interests:') ?></h3>
	  <?php foreach ($interests as $val): ?>
	    <?php echo $val->getSubreaktor()->getName(); ?><br />
	  <?php endforeach ?>
	<?php endif ?>
	<?php if((!$user->getEmailPrivate() && $sf_user->isAuthenticated()) || $user->getIcq() || $user->getHomepage() || $user->getMsn()): ?>
	  <strong><?php echo __('Contact information') ?></strong><br />
	   
	  <?php $mouseoverStart = "Tip('<div class = \'tool_tip_internal\'>" // Start javascript for mouseover ?>
	  <?php $mouseoverEnd   = "</div>', FADEIN, 300, LEFT, true, FOLLOWMOUSE, false, DURATION, -5000)" // End javascript ?>
	  
	  <?php $mouseOut   = "UnTip()"; //Do not display box when not mousing over?>  
	   
	  <?php if (!$user->getEmailPrivate() && $sf_user->isAuthenticated()):
	     // Check if user allows for displaying e-mail address, and only display to logged in users, it'll
	     // keep the spammers away ?>
	    <?php $mouseover = $mouseoverStart."<strong>".__('Email:') . "</strong><br />".
	      mail_to($user->getEmail(), $user->getEmail(), array('encode'=> true)).$mouseoverEnd ?> 
	    <?php echo mail_to($user->getEmail() ,image_tag('email.png', array(
	            'onmouseover' =>  $mouseover,
	            'onmouseout' => $mouseOut)), array(
	            'encode'=> true
	    )) ?>
	  <?php endif; ?>
	  
	  <?php if ($user->getHomepage()): // Check if user has provided a homepage ?>
	    <?php $mouseover = $mouseoverStart."<strong>".__('Homepage:') . "</strong><br />".
	      link_to($user->getHomepage(), $user->getHomepage()).$mouseoverEnd?> 
	    <?php echo link_to(image_tag('homepage.png', array(
	            'onmouseover' =>  $mouseover,
	            'onmouseout' => $mouseOut)), $user->getHomepage()) ?>
	  <?php endif; ?>
	    
	  <?php if ($user->getIcq()): // Check if user has provided icq ?>
	    <?php $mouseover = $mouseoverStart."<strong>".__('ICQ:') . "</strong><br />".$user->getIcq().$mouseoverEnd?> 
	    <?php echo image_tag('icq.png', array(
	            'onmouseover' => $mouseover,
	            'onmouseout'  => $mouseOut)) ?>
	  <?php endif; ?>
	  
	  <?php if ($user->getMsn()): // Check if user has provided msn ?>
	    <?php $mouseover = $mouseoverStart."<strong>".__('MSN:') . "</strong><br />".$user->getMsn().$mouseoverEnd?> 
	    <?php echo image_tag('msn.png', array(
	            'onmouseover' =>  $mouseover,
	            'onmouseout' => $mouseOut)) ?>        
	  <?php endif; ?>
	<?php endif; ?>
</div>
