<?php
/**
 * Partial displaying a list of a user's moderator links
 *
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * 
 */
?>
<h2><?php echo 'Moderator' ?></h2>
<?php if ($sf_user->hasCredential('approveartwork')): ?>
	<ul class="padding_top" id ="moderator_main_links">
	  <?php if (!$artwork->isApproved()): ?>
	    <li id="approve_artwork_moderator_link" class ="approve_artwork">
	      <?php echo link_to_remote(__("Approve"), array(   
	          'complete'=> "$('approve_artwork_moderator_link').innerHTML = '" . __('Approving... please wait') . "';",
	          'url' => '@artwork_status?status=3&id='.$artwork->getId(),
	      	  'success' => "location.reload();"
	        ), array("id" => "approve_button_".$artwork->getId()))?>
	    </li>
	  <?php endif; ?>
 <li class ="mark_discussion">
    <?php echo link_to_remote(__('Flag artwork for discussion'), array(
    'complete'=> "parent.window.location = '".reaktor_url_for('@show_discussion?id='.$artwork->getId().'&type=artwork')."'",
    'url'    => '@artwork_mark_discussion?status=1&id='.$artwork->getId(),
    )) ?>
</li>
	  <?php if (!$artwork->isRejected()): ?>
	    <li class ="reject"><?php echo link_to(__('Reject artwork'), '@rejectartwork?id='.$artwork->getId())  ?></li>
	  <?php endif; ?>
	</ul>
<?php endif; ?>
<ul>
  <li>
    <?php echo link_to(__('Show user portfolio'), '@portfolio?user=' . $artwork->getUser()->getUsername()); ?>
  </li>
  <?php if ($sf_user->hasCredential('viewmetadata')): ?>
    <li>
      <?php echo reaktor_link_to(__('Show metadata'), '@show_artwork_metadata?id='.$artwork->getId().'&title='.$artwork->getTitle()) ?>
    </li>
  <?php endif; ?>
</ul>
<ul class="padding_top">
  <?php if ($sf_user->hasCredential('approvetags')): ?>
    <li class="administer_tags"><?php echo link_to(__('Administer tags'), '@edit_artwork?id=' . $artwork->getId()); ?></li>
  <?php endif ?>
  <?php if (isset($thefile) && $sf_user->hasCredential('downloadoriginalfile')): ?>
    <li class="download_original"><?php echo link_to(__('Last ned original-fil'), contentPath($thefile, 'original', true)); ?></li>
  <?php endif; ?>
</ul>
