<?php
/**
 * To be able to comment on each artwork, a user needs to enter the title, and the comment in a form. 
 * This template provides that form. To use it, you must at least send the object and the namespace. See an example below.
 * 
 * get_component('sfComment', 'commentForm', array('object' => $object, 'namespace' => $namespace,  'parentId' => $comment['Id']))
 * - $object The article object the comment should be added to   
 * - $namespace This is either 'frontend' or 'admin', comments can be added by users, but an artwork can also be discussed by admin users.
 * - $parentId The comments can be nested, in a list, if replying to a thread, the parent Id is needed
 * 
 * The controller has the possibility to pass the following information:
 * 
 * The following are configuration data from REAKTOR_ROOT/apps/reaktor/config/app.yml (which fields are required, how to get userinfo etc)
 * - $config_user    
 * - $config_anonymous
 * 
 * Depending on whether the user is logged in or not these are either user or anonymous  
 * - $config_used: set to either $config_used or $config_anonymous 
 * - $action: which action to run when submitting form (authenticatedComment or anonymousComment)
 * 
 */

/*
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */ 
?>

<?php use_helper('Javascript', 'Date','Validation', 'wai'); ?>

<?php if ( ($sf_user->isAuthenticated() && $config_user['enabled'])
          || $config_anonymous['enabled']): ?>
  <?php if (!isset($parentId)): ?>
  <div class="new_comment_header">
  <h4><?php echo __('Write a new comment') ?></h4>
  </div>
<?php endif ?>
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
          <?php echo wai_label_for("sf_comment_name", __('Name')) ?>
          <?php echo input_tag('sf_comment_name') ?>
        </div>
      <?php endif; ?>

      <?php if (isset($config_used['layout']['email'])): ?>
        <div class="<?php echo $config_used['layout']['email']; ?>">
          <?php echo form_error('sf_comment_email') ?>
          <?php echo wai_label_for('sf_comment_email', __('Email')); ?>
          <?php echo input_tag('sf_comment_email') ?>
        </div>
      <?php endif; ?>

      <?php if (isset($config_used['layout']['title'])): ?>
        <div class="<?php echo $config_used['layout']['title']; ?>">
          <?php echo form_error('sf_comment_title') ?>
          <?php echo wai_label_for("sf_comment_title", __("Title")) ?>
          <?php echo input_tag('sf_comment_title') ?>
        </div>
      <?php endif; ?>

      <div class="required">
        <?php echo form_error('sf_comment') ?>
        <?php echo wai_label_for("sf_comment", __("Write a comment")) ?>
        <?php echo textarea_tag('sf_comment') ?>
      </div>
      <div>
      <?php echo checkbox_tag('sf_comment_email_notify',1,false) ?>
      <?php echo wai_label_for("sf_comment_email_notify", __("Email me when somone answers my comment"), array("style" => "display: inline;")); ?>
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
    <?php if (isset($parentId)): ?>
      <?php echo input_hidden_tag('comment_parent_id', $parentId) ?>
    <?php endif; ?>
      <?php if (isset($namespace) && ($namespace != null)): ?>
      <?php echo input_hidden_tag('sf_comment_namespace', $namespace) ?>
    <?php endif; ?>

    <?php if ($config['use_ajax']): ?>
      <div id="sf_comment_ajax_indicator<?php if (isset($parentId)) echo $parentId ?>" style="display: none">&nbsp;</div>
      <?php
      if (!isset($parentId)) $parentId='';
      echo submit_to_remote('sf_comment_ajax_submit',
                           __('Post this comment'),
                           array('update'   => array('success' => 'all_sf_comments_list', 'failure' => 'comment_new'),
                                 'url'      => 'sfComment/'.$action,
                                 'loading'  => "Element.show('sf_comment_ajax_indicator" . $parentId . "')",
                                 'complete' => "Element.hide('sf_comment_ajax_indicator" . $parentId . "');Element.scrollTo('all_sf_comment_list')",
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
