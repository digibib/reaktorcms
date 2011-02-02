<?php use_helper('recaptcha'); ?>

<?php echo recaptcha_mailhide_html(sfConfig::get('app_mailhide_publickey'), 
  sfConfig::get('app_mailhide_privatekey'), "foo@bar.com"); ?>