<?php
/**
 * Users who want to interact with the Reaktor site, need to be logged in. To be able to log 
 * in they need to register first, which is what this template provides, a form for users to 
 * register. The form itself is retrived from a partial.
 * 
 * From the action the following information is given:
 * $sf_guard_user - an empty sfGuardUser object, the object will be populated when the form i posted 
 * $residence_array - the possible residences a user can choose from in the residence drop down
 * 
 * PHP Version 5
 *
 * @author    Ole-Petter <olepw@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

reaktor::setReaktorTitle(__('Register'));
use_helper('Validation', 'Object', 'Date', 'Javascript', 'recaptcha', 'wai');

?>

<h1><?php echo __('Register as a user'); ?></h1>
<p><?php echo __('To register, please fill out the fields below. Required fields are marked with an asterisk.'); ?></p>
<br />
<?php echo form_tag('profile/create'); ?>
  <div class = "profile_left">
    <?php include_partial('userProfile', array(
      'sf_guard_user'   =>$sf_guard_user, 
      'profile'         =>'create', 
      'residence_array' => $residence_array 
    )); ?>  
      
    <br />
    <?php echo wai_label_for("recaptcha_response_field", __("Spam bot control")); ?>
    <div>
      <?php if(form_has_error('recaptcha_response_field')): ?>
        <?php // The actual response error messages are not for humans, we have to overwrite it ?>
        <?php $sf_request->setError('recaptcha_response_field', __("Please fill out the CAPTCHA correctly")); ?>
        <?php echo form_error('recaptcha_response_field'); ?>
      <?php endif; ?>
      <?php echo recaptcha_get_html(sfConfig::get('app_recaptcha_publickey'), 
                       $sf_request->getError('recaptcha_response_field')); ?>
	<script type="text/javascript">
	var RecaptchaOptions = {
		lang: 'no'
	}
	function translateRecaptcha() {
		if ($('recaptcha_instructions_image').innerHTML == "Type the two words:") {
			$("recaptcha_instructions_image").innerHTML = "<?php echo __("Type the two words:"); ?>";
		}
		if ($('recaptcha_instructions_audio').innerHTML == "Type the eight numbers:") {
			$("recaptcha_instructions_audio").innerHTML = "<?php echo __("Type the eight numbers:"); ?>";
		}
		if ($('recaptcha_reload_btn').getAttribute("title") == "Get a new challenge") {
			$('recaptcha_reload_btn').setAttribute("title", "<?php echo __("Get a new challenge"); ?>");
		}
		if ($('recaptcha_reload').getAttribute("alt") == "Get a new challenge") {
			$('recaptcha_reload').setAttribute("alt", "<?php echo __("Get a new challenge"); ?>");
		}
		if ($('recaptcha_switch_audio').getAttribute("alt") == "Get an audio challenge") {
			$('recaptcha_switch_audio').setAttribute("alt", "<?php echo __("Get an audio challenge"); ?>");
		}
		if ($('recaptcha_switch_audio_btn').getAttribute("title") == "Get an audio challenge") {
			$('recaptcha_switch_audio_btn').setAttribute("title", "<?php echo __("Get an audio challenge"); ?>");
		}
		if ($('recaptcha_whatsthis').getAttribute("alt") == "Help") {
			$('recaptcha_whatsthis').setAttribute("alt", "<?php echo __("Help")?>");
		}
		if ($('recaptcha_whatsthis_btn').getAttribute("title") == "Help") {
			$('recaptcha_whatsthis_btn').setAttribute("title", "<?php echo __("Help")?>");
		}
		if ($('recaptcha_switch_img').getAttribute("alt") == "Get a visual challenge") {
			$('recaptcha_switch_img').setAttribute("alt", "<?php echo __("Get a visual challenge")?>");
		}
		if ($('recaptcha_switch_img_btn').getAttribute("title") == "Get a visual challenge") {
			$('recaptcha_switch_img_btn').setAttribute("title", "<?php echo __("Get a visual challenge")?>");
		}
	}
	setTimeout("translateRecaptcha();", 5);
	</script>

    </div>
    <div id="recaptca_text">
    <?php echo __('The words on the left come from scanned books. By typing them, you help to digitize old texts.'); ?>
    </div>
    <br /><br />
    <div class ="right_buttons">
      <?php echo submit_tag(__('Register me')); ?>
      <?php echo reaktor_button_to(__('Cancel'), '@home'); ?>
    </div>
  </div>
  <div class='profile_right'>
    <h2 id='information_msg'>
        <?php echo __('**help-text when no field is selected**'); ?>
    </h2>    
  </div>  
</form>

<?php echo javascript_tag("
	$('recaptcha_instructions_image').innerHTML='".__("Type the two words:")."';
"); ?>
