<?php
/**
 * List all emails from users with the opt-in flag set.
 *
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */ 

reaktor::setReaktorTitle(__('Mailing list'));

?>
<h1> <?php echo __('List all recipients who would like promotional e-mails') ?></h1>
<div>
  <?php 
  $counter              = 1;
  $block                = 1;
  $email_count_in_block = sfConfig::get('app_admin_opt_in_email_blocks', 20);
  
  if($email_count_in_block > 1):
  ?>
    <b> 
      <?php echo 'Block '.$block.': '; ?> 
    </b>
    <?php    
    foreach($emails as $email): 
      //print out email     
      echo $email.'; ';
      
      //make sure each block only contains a certain number of e-mails    
      $counter++;
      if($counter > $email_count_in_block):     
        $counter = 0;
        ?>
        <br />  
        <br />
        <?php  $block++ ?>
        <b><?php echo 'Block '.$block.': ' ?> </b>
     <?php 
      endif;
    endforeach;
  else:
    foreach($emails as $email): 
      //print out email     
      echo $email.';';
    endforeach;
  endif;
  ?>
</div>
