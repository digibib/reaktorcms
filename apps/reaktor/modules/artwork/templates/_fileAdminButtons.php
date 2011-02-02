<?php 
/**
 * Admin buttons for artwork administration
 *
 * PHP Version 5
 *
 * @author    June Henriksen <juneih@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

use_helper("Javascript");

?>
<div id = "admin_buttons_<?php echo $artwork_file->getId()?>" style = "display: inline">
 
    <?php echo button_to_remote(__("Flag file ok"), array(   
          'url' => '@flag_suitable_file?id='.$artwork_file->getId(),
          'complete'=> "Effect.BlindUp('artwork_list_container_".$artwork_file->getId()."');",
          'confirm' => __("Flag this file as OK?"),
        ), array("id" => "flag_ok_button_".$artwork_file->getId())); ?>
        
    <?php echo button_to_function(__("Rejection message"), "$('rejectionmsg_".$art->getId()."').toggle()"); ?>       
</div>