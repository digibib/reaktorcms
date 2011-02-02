<?php
/**
 * Template for showing all the user's artwork
 * 
 * Variables available to this template provided by the action:
 * - $thisUser    : The user object of the owner of this work - either the logged in user or if in admin mode could be a different user
 * - $artworks    : Array of artwork objects
 * - $titleFilter : An extra descriptive word such as "submitted" that shows the page we are looking at
 * 
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

if ($thisUser->getId() == $sf_user->getId()) 
{
  $title = __("My artwork with status: %filter_eg_submitted% %from_year_statement%", 
     array("%filter_eg_submitted%" => ucfirst($titleFilter),
           "%from_year_statement%" => ($sf_params->get("year") ? __("%artworks_statement% in %year%", 
                                                                 array("%year%" => $sf_params->get("year"),
                                                                       "%artworks_statement%" => "")) : "")));
}
else 
{
  $title = __("(%username%), artwork with status: %filter_eg_submitted% %from_year%", 
               array("%username%" => $thisUser->getUsername(),
                     "%filter_eg_submitted%" => ucfirst($titleFilter),
                     "%from_year%" => ($sf_params->get("year") ? "(".$sf_params->get("year").")" : ""
                                                                       )));
}
reaktor::setReaktorTitle($title);
?>
<?php include_partial("sideMenu"); ?>
<div id="my_content">
  <div id = "user_artwork_list">
    <?php     
  switch ($mode)
  {
    case 'draftartwork':
      ?>
      <div class="message status_draft">
      <h2><?php echo __('Artwork status'); ?>:</h2>&nbsp;
      <h2 class="status_draft"><?php echo __('Draft'); ?></h2>
      <br class="clearboth" />
      <p><?php echo __("These artworks have not yet been submitted for approval"); ?></p>
      </div>
      <?php
      break;
    case 'submittedartwork':
      ?>
      <div class="message status_submitted">
      <h2><?php echo __('Artwork status'); ?>:</h2>&nbsp;
      <h2 class="status_submitted"><?php echo __('Awaiting approval'); ?></h2>
      <br class="clearboth" />
      <p><?php echo __("These artworks have been submitted for approval"); ?>.</p>
      </div>
      <?php
      break;
    case 'allapproved':
      ?>
      <div class="message status_approved">
      <h2><?php echo __('Artwork status'); ?>:</h2>&nbsp;
      <h2 class="status_approved"><?php echo __('Approved'); ?></h2>
      <br class="clearboth" />
      <p><?php echo __("These artworks have been approved, and are visible to all users"); ?>.</p>
      </div>
      <?php
      break;
    case 'allrejected':
      ?>
      <div class="message status_rejected">
      <h2><?php echo __('Artwork status'); ?>:</h2>&nbsp;
      <h2 class="status_rejected"><?php echo __('Rejected'); ?></h2>
      <br class="clearboth" />
      <p><?php echo __("These artworks have been rejected by a member of the editorial team"); ?></p>
      </div>
      <?php
      break;
    default:
      ?>
      <h1><?php echo __('All my artwork'); ?></h1>
      <?php
  }
    
    ?>
    <?php if ($allowOrdering): ?>
      <?php /* ?><p>
        <?php echo __("Click the thumbnails and drag the artworks to order them - this will affect how they appear on some public lists"); ?> 
      </p> */ ?>
      <br />
      <?php include_partial("artwork/draganddropartworklist", array("artworks" => $artworks, "thisUser" => $thisUser)); ?>
    <?php else: ?>
      <ul id= "artwork_list">
        <?php foreach ($artworks as $artwork): ?>
          <?php if ($artwork->getFilesCount() == 0) continue; ?>
          <li id="artwork_<?php echo $artwork->getId(); ?>" class="bottomborder">
            <?php include_component("artwork", "userArtworkListElement", array("artwork" => $artwork, "thisUser" => $thisUser)); ?>  
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </div>
</div>