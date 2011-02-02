<?php
/**
 * Template for showing all the files a user has ever uploaded
 * 
 * Variables available to this template provided by the action:
 * - $thisUser : The user object of the owner of this work - either the logged in user or if in admin mode could be a different user
 * - $files    : Array of file objects
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
  $title = __("My %filter_eg_submitted% files", array("%filter_eg_submitted%" => $titleFilter));
}
else 
{
  $title = __("%filter_eg_submitted% files for %username%", 
               array("%username%" => $thisUser->getUsername(),
                     "%filter_eg_submitted%" => strtoupper($titleFilter)));
}
$rowCount = 1;
reaktor::setReaktorTitle($title);
?>
<?php include_partial("sideMenu"); ?>
<div id ="my_content">
  <div id = "user_artwork_list">
    <h1><?php echo $title; ?></h1><?php /* echo " [ ".reaktor_link_to(__("back to 'manage my content' menu"), $route."?user=".$thisUser->getUsername()."&mode=menu")." ]"; */ ?>
    <br /><br />
  </div>
  <?php if (!empty($files)): ?>
    <ul id= "artwork_list">
      <?php foreach ($files as $file): ?>
      	<?php $rowCount++; ?>
        <li id = "file_<?php echo $file->getId(); ?>" class="filerow" <?php /* echo ($rowCount % 2) ? "class='evenrow'" : ""; */ ?>>
          <?php include_partial("userFileInList", array("file" => $file, "thisUser" => $thisUser)); ?>  
        </li>
      <?php endforeach; ?>
    </ul>
  <?php elseif ($thisUser->getId() == $sf_user->getId()): ?>
    <?php echo __("You do not have any %filter_eg_submitted% files", array("%filter_eg_submitted%" => $titleFilter))." - ".reaktor_link_to(__("click here to upload more!"), "@upload_content"); ?>
  <?php else: ?>
    <?php echo __("This user does not have any %filter_eg_submitted% files", array("%filter_eg_submitted%" => $titleFilter)); ?>
  <?php endif; ?>
</div>
