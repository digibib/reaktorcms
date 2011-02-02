<?php
/**
 * Partial for displaying flash media players 
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

use_helper("Javascript", "content");
?>

<?php switch ($mode) { ?>
<?php case "video": ?>

  <?php if ($file->getMimeType()=='image/gif' && file_exists($file->getFullFilePath('original'))): ?>

<img src="<?php echo "/".sfConfig::get("app_upload_upload_dir")."/".$file->getId()."/".$file->getFilename(); ?>" >

  <?php elseif (file_exists($file->getFullFilePath())): ?> 
    <?php echo javascript_tag("
      VM_EmbedFlash ( 'width', '480', 'height', '360', 
                      'src', '/flowplayer/FlowPlayerLight.swf',
                      'flashvars', \"config={videoFile: '/".sfConfig::get("app_upload_upload_dir")."/".$file->getId()."/".$file->getFilename()."', loop: false, autoRewind: true, autoPlay: false, videoLink:'http://".$sf_request->getHost().contentPath($file)."'}\");"); ?>

  <?php elseif (file_exists($file->getFullFilePath().".temp.flv")): ?>
    <div class = "warning_box box_shape">
      <br /><br />
      <?php echo __("Video transcoding has not completed - no preview available"); ?>
      <?php if ( $sf_user->hasCredential('reruntranscoding') || $sf_user->hasCredential("staff")): ?>
<?php include_partial ("transcoderOptions", array("file" => $file)); ?>
      <?php endif; ?>
    </div>


  <?php else: ?>
    <div class = "warning_box box_shape" id="player_warning">
      <br /><br />  
      <?php echo __("Couldn't find the file %filename%", array('%filename%' => $file->getTitle())); ?><br />
      <?php if ( $sf_user->hasCredential('reruntranscoding') || $sf_user->hasCredential("staff")): ?>
<?php include_partial ("transcoderOptions", array("file" => $file)); ?>
      <?php endif; ?>

    </div>


  <?php endif; ?>

  <?php break; ?>

<?php case "audio": ?>
  <?php if (file_exists($file->getFullFilePath())): ?>
     <?php $url      = '/xspf_player/xspf_player.swf?playlist_url='.url_for($artwork->getLink('xml').'&format=xspf');
     if ($artwork->getFilesCount() == 1 || true)
     {
     	 $height = 153;
     }
     else
     {
     	 $height = 15;
     }
     echo javascript_tag("
      VM_EmbedFlash ( 'width', '100%', 'height', $height, 
                'src', '$url', 'bgcolor', '#e6e6e6'); 
    
    "); // bgcolor = c6c6c6 will make it same color as rest of player ?>
  <?php elseif (file_exists($file->getFullFilePath().".temp.mp3") ): ?>
    <div class = "warning_box box_shape">
      <br /><br />  
      <?php echo __("Audio transcoding has not completed - no preview available"); ?>
    </div>
    <?php if ($sf_user->hasCredential('reruntranscoding') || $sf_user->hasCredential("staff")): ?>
      <?php include_partial ("transcoderOptions", array("file" => $file)); ?>     
    <?php endif; ?>
  <?php else: ?>
    <?php echo __("Couldn't find the file %filename%", array('%filename%' => $file->getrealPath())); ?>
    <?php if ($sf_user->hasCredential('reruntranscoding') || $sf_user->hasCredential("staff")): ?>  
      <?php include_partial ("transcoderOptions", array("file" => $file)); ?>     
    <?php endif; ?>
  <?php endif; ?>
<?php break; ?>
<?php } // End switch ?>





