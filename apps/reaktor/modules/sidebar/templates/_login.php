<?php
/**
 * Login partial called from sidebar
 * 
 * This page appears in the sidebar when a user is not logged in
 *
 * PHP Version 5
 *
 * @author    June <Juneih@linpro.no>
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
use_helper("Javascript", 'wai');
$loginStyle = $lostPassStyle = "";
if ($sf_params->get("toemail"))
{
  $loginStyle = "Display: none";
}
else
{
  $lostPassStyle = "Display: none";
}
?>
<div id="user_summary">
	<div id="sf_guard_auth_form" style="<?php echo $loginStyle; ?>">
    <?php echo form_tag('@sf_guard_signin') ?>
    <?php echo input_hidden_tag('subreaktor', Subreaktor::getProvidedIfValid()) ?>
    <fieldset>
    	<h3><?php echo __('Sign in'); ?></h3> 
    
    	<div class="form-row" id="sf_guard_auth_username">
        <?php
        echo form_error('username'), 
        wai_label_for('username', __('Username:'))."<br />",
        input_tag('username', $sf_data->get('sf_params')->get('username'), array("class" => "sidebar_text", "title" => __('Username')));
        ?>
      </div>

      <div class="form-row" id="sf_guard_auth_password">
        <?php
        echo form_error('password'), 
          wai_label_for('password', __('Password:'))."<br />",
          input_password_tag('password', '', array("class" => "sidebar_text", "title" => __('Password')));
        ?>
      </div>
      
      <div class="form-row" id="sf_guard_auth_remember">
        <?php
        echo wai_label_for('remember', __('Remember me?')),
        checkbox_tag('remember');
        ?>
      </div> 
    </fieldset>  

    <?php echo submit_tag(__('Sign in'), array('id'=>'sf_guard_auth_button', 'class' =>'button')).'<br />'; ?>
    <?php echo link_to_function(__('Forgot your password?'), "lostPassToggle();"); ?>
    <br />
    <?php echo reaktor_link_to(__("Login help"), "@article?permalink=".sfConfig::get("app_fixed_articles_login_help", "login_help")); ?>
    <br />
    <?php echo reaktor_link_to(__('Register'), '@register');?> 
    <?php echo input_hidden_tag('referer', $sf_params->get('referer') ? $sf_params->get('referer') : sfRouting::getInstance()->getCurrentInternalUri()); ?>
 	  </form>
	</div>
	<div id = "lost_pass" style="<?php echo $lostPassStyle; ?>">
		<?php include_partial("profile/passRequest"); ?>
	</div>
</div>
