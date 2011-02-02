<?php use_helper('Form'); ?>
<?php use_helper('Validation'); ?>
<?php use_helper('Javascript'); ?>
<?php use_helper('I18N'); ?>
<?php use_helper('Date'); ?>

<?php if ( ($sf_user->isAuthenticated() && $config_user['enabled'])
          || $config_anonymous['enabled']): ?>
  <?php
  echo form_tag('sfComment/'.$action, 
                array('class' => 'sf_comment_form', 
                      'id'    => 'sf_comment_form', 
                      'name'  => 'sf_comment_form'));
  ?>
    <fieldset>
      <?php if ($sf_request->hasError('unauthorized')): ?>
        <div class="sf_comment_form_error">
          <?php echo $sf_request->getError('unauthorized') ?>
        </div>
      <?php endif; ?>

      <?php if (isset($config_used['layout']['name'])): ?>
        <div class="<?php echo $config_used['layout']['name']; ?>">
          <?php echo form_error('sf_comment_name') ?>
          <label for="sf_comment_name"><?php echo __('Name') ?></label>
          <?php echo input_tag('sf_comment_name') ?>
        </div>
      <?php endif; ?>

      <?php if (isset($config_used['layout']['email'])): ?>
        <div class="<?php echo $config_used['layout']['email']; ?>">
          <?php echo form_error('sf_comment_email') ?>
          <label for="sf_comment_email"><?php echo __('Email') ?></label>
          <?php echo input_tag('sf_comment_email') ?>
        </div>
      <?php endif; ?>

      <?php if (isset($config_used['layout']['title'])): ?>
        <div class="<?php echo $config_used['layout']['title']; ?>">
          <?php echo form_error('sf_comment_title') ?>
          <label for="sf_comment_title"><?php echo __('Title') ?></label>
          <?php echo input_tag('sf_comment_title') ?>
        </div>
      <?php endif; ?>

      <div class="required">
        <?php echo form_error('sf_comment') ?>
        <label for="sf_comment"><?php echo __('Write a comment') ?></label>
        <?php echo textarea_tag('sf_comment') ?>
      </div>
    </fieldset>

    <?php
    switch (sfConfig::get('sf_path_info_array'))
    {
      case 'SERVER':
        $pathInfoArray =& $_SERVER;
        break;
      case 'ENV':
      default:
        $pathInfoArray =& $_ENV;
    }

    $referer = sfRouting::getInstance()->getCurrentInternalUri();
    
    if ($pathInfoArray['QUERY_STRING'] != '')
    {
      $referer .= '?'.$pathInfoArray['QUERY_STRING'];
    }
    ?>
    <?php echo input_hidden_tag('sf_comment_referer', sfContext::getInstance()->getRequest()->getParameter('sf_comment_referer', $referer)) ?>
    <?php echo input_hidden_tag('sf_comment_object_token', $token) ?>

    <?php if (isset($namespace) && ($namespace != null)): ?>
      <?php echo input_hidden_tag('sf_comment_namespace', $namespace) ?>
    <?php endif; ?>

    <?php if ($config['use_ajax']): ?>
      <div id="sf_comment_ajax_indicator" style="display: none">&nbsp;</div>
      <?php
      echo submit_to_remote('sf_comment_ajax_submit',
                           __('Post this comment'),
                           array('update'   => array('success' => 'sf_comment_list', 'failure' => 'sf_comment_form'),
                                 'url'      => 'sfComment/'.$action,
                                 'loading'  => "Element.show('sf_comment_ajax_indicator')",
                                 'complete' => "Element.hide('sf_comment_ajax_indicator');Element.scrollTo('sf_comment_list')",
                                 'script'   => true),
                           array('class' => 'submit'));
      ?>
      <noscript>
        <?php echo submit_tag(__('Post this comment'), array('class' => 'submit')) ?>
      </noscript>
    <?php else: ?>
      <?php echo submit_tag(__('Post this comment'), array('class' => 'submit')) ?>
    <?php endif; ?>
  </form>
<?php endif; ?>