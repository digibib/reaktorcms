<?php echo javascript_tag("

    function completeCallback_custom(response) 
    {
    // make something useful after (onComplete)
    $('image_block').innerHTML = response;
    $('avatar_image').innerHTML = response;
     
    $('newimage').value = '';
    document.getElementById('avatar_edit_new').style.display='none';
                        }

") ?>

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

                        







<div id = "avatar_edit_new" style="display: none">
 <?php echo wai_label_for("newimage", __("User Avatar").":", array("id" => "avatar_label")); ?>
 <br /><br />
  <?php
  $avatar_path = !is_null($sf_guard_user->getAvatar()) ? $sf_guard_user->getAvatar() : "default.gif";
  echo "<p>";
  echo include_partial('upload/inlineUpload', 
     array(
     "completeCallback" => 'completeCallback_custom', 
     "extra_button" => "<input type=\"button\" value=\"".__("Cancel")."\" onclick=\"document.getElementById('avatar_edit_new').style.display='none';$('newimage').value = '';\">", 
     "avatarUserId" => $thisUserId, 
     "imgTag" => image_tag(sfConfig::get("app_profile_avatar_url").$avatar_path)
     )
   );
   echo "</p>";
  ?>
</div>
<?php endif; ?>


<?php echo javascript_tag('window.setTimeout("clearPasswordBoxes();", 250)'); ?>
