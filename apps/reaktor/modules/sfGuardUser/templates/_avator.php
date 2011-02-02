<?php
/**
 * Footer for the edit view 
 *  
 * PHP version 5
 * 
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */



use_helper('wai');

if ($sf_params->get('id') && $sf_user->hasCredential("edituser"))
{
  $thisUserId = $sf_params->get('id');
}
elseif ($sf_user->isAuthenticated())
{
  $thisUserId = $sf_guard_user->getId(); 
}

if (isset($thisUserId)):
?> 
 <?php // echo wai_label_for("newimage", __("User Avatar").":", array("id" => "avatar_label")); ?>
 <br /><br />
  <?php

  $avatar_path = !is_null($sf_guard_user->getAvatar()) ? $sf_guard_user->getAvatar() : "default.gif";
echo '<table><tr>';
echo '<td  id = "avatar_image">'.image_tag(sfConfig::get("app_profile_avatar_url").$avatar_path).'</td>';
echo "<td><input type=\"button\" value=\"".__("Set new image")."\" onclick=\"document.getElementById('avatar_edit_new').style.display='block'\"></td>";
echo '</tr></table>';

  ?>
<?php endif; ?>




