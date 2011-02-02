<?php
/**
 * template for messages
 *  
 * PHP version 5
 * 
 * @author    Ole-Petter Wikene <olepw@linpro.no> 
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
?>
<?php use_helper('Javascript');?> 
  <div class="message_wrapper">
  <?php echo periodically_call_remote(array(
                                            'frequency' => 300,
                                            'update' => 'message_summary',
                                            'url' => '@newMessages',
                                            'script' => true,
  )
  ) ?>
  <div class="message_summary" id="message_summary">
    <?php include_component("messaging","messagesSummary",array('sf_user' => $sf_user)) ?>
  </div>
  </div>
