<?php use_helper('recaptcha'); ?>

<?php echo form_tag('recaptcha/index'); ?>
  <?php echo recaptcha_get_html(sfConfig::get('app_recaptcha_publickey'), 
    $sf_request->getError('recaptcha_response_field')); ?>
  <?php echo submit_tag('submit'); ?>
</form>