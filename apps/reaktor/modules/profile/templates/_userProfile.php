<?php
/**
 * One of the most important features of a community, is to be able to mark yourself as a member of it. After all, if you're not a member
 * how will the system know it's you, so as to be able to group your artworks, send you messages, etc. To become a member, you need to 
 * register, this is the template displaying the form where the user enters information about him- or herself.  This file is included in 
 * profile/registerSuccess.php and profile/editSuccess.php to avoid repeating code. The forms' start tags are in these templates. 
 * 
 * Example on how to use it
 * include_partial('userProfile', array(
 *     'sf_guard_user'   => $sf_guard_user, 
 *     'profile'         =>'create', 
 *     'residence_array' => $residence_array))
 *
 * The following parameters need to be passed:
 * sf_guard_user   - A sf_guard_user object of the user whose profile is to be either created or edited 
 * profile         - Not mandatory, if not set its assumed to be edit, if set set to create the mode is assumed to be create
 * residence_array - An array of arrays, which city, municipal or county can the user choose between in the residence drop down. 
 * 
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
use_helper('Javascript', 'wai');
?>

<?php echo object_input_hidden_tag($sf_guard_user, 'getId'); //Hide the users id?>

<?php echo wai_label_for('username_profile', __('User name'));  // Username ?>
<?php if($profile == 'create'): ?><span class="required_star">*</span><?php endif; ?><br />
<?php echo form_error('username_profile'); ?>

<?php echo javascript_tag("
	function clearUsernameCheck()
  {
  
  	$('username_status').innerHTML='".__("Checking username availability")."';
  	$('username_check_img').src='/images/spinning18x18.gif';

	}

	var ignoreKeycodes =[9,37,38,39,40,16,17,18,93,144,20,33,34,35,36,145]; 
"); ?>

<?php echo object_input_tag($sf_guard_user, 'getUsername', array (
  'size'         => 30, 
  'onfocus'      => "$('information_msg').innerHTML='".__('**help-text for username**')."'",
  'onblur'       => "$('information_msg').innerHTML='".__('**help-text when no field is selected**')."'",
// For some reason some of web browsers doesn't triger onkeyup event when typing special characters like øåæ - Thats the reason wy checkUsername(); method has been moved to onkeydown event
//  'onkeyup'      => "if (!ignoreKeycodes.include(event.keyCode)) {  checkUsername(); }",
  'onkeydown'    => "if (!ignoreKeycodes.include(event.keyCode)) { clearUsernameCheck(); checkUsername(); }",
  'id'           => 'username_profile',
  'name'         => 'username_profile'
)); ?>

<p>
<?php echo image_tag("karakter_gronn.gif", array("id" => "username_check_img", "size" => "12x12")); ?>
	<span id="username_status">
  	<span><?php echo __("Username availability will be displayed here"); ?></span>
 	</span>
</p>
<br />

<?php if ($profile == 'create'): //Password?>

  <?php echo wai_label_for('password_profile', __('Password')); ?>
  <?php if($profile == 'create'): ?><span class="required_star">*</span><?php endif; ?><br />
  <?php echo form_error('password_profile'); ?>
  <?php echo input_password_tag('password_profile', '', array (
    'size'    => 20, 
    'id'      => 'password_profile',
    'name'    => 'password_profile',
    'onblur'  => "$('information_msg').innerHTML='".__('**help-text when no field is selected**')."'", 
    'onfocus' => "$('information_msg').innerHTML='".__('**help-text for password')."'"
  )); ?><br />
  
  <?php echo wai_label_for('password_repeat', __('Repeat password')); ?>
  <?php if($profile == 'create'): ?><span class="required_star">*</span><?php endif; ?><br />
  <?php echo form_error('password_repeat'); ?>
  <?php echo input_password_tag('password_repeat', '', array(
    'onblur'  => "$('information_msg').innerHTML='".__('**help-text when no field is selected**')."'", 
    'onfocus' => "$('information_msg').innerHTML='".__('**help-text for password_repeat**')."'"
  )); ?><br />

<?php endif ?>

<?php echo wai_label_for('email', __('Email address'));   //E-mail?>
<?php if ($profile == 'create'): ?>
  <span class="required_star">*</span>
  <?php $emailhelptext = __('**help-text for email on registration**'); ?>
<?php else: ?>
  <?php $emailhelptext = __('**help-text for email on profile edit**'); ?>
<?php endif; ?><br />
<?php if ($sf_guard_user->getNewEmail() != '' && !$sf_user->hasCredential('editprofile')): ?>
  <?php echo form_error('email'); ?>
  <?php echo object_input_tag($sf_guard_user, 'getNewEmail', array(
    'size' => 80, 
    'onfocus'=> "$('information_msg').innerHTML='".$emailhelptext."'"
  )); ?>
    <?php echo __('A verification email has been sent to this email address.')?><br />
    <?php echo __('To verify it, please click the verification link in the email you have received.')?>
    <b><?php echo __("If you don't want to change your email address, please click %url%", array(
      '%url%' => link_to(__('here'), 'profile/edit?revert_email=yes')))?></b>
<?php else: ?>
    <?php echo form_error('email'); ?>
    <?php echo object_input_tag($sf_guard_user, 'getEmail', array(
      'size'    => 80,
      'onblur'  => "$('information_msg').innerHTML='".__('**help-text when no field is selected**')."'",
      'onfocus' => "$('information_msg').innerHTML='".$emailhelptext."'"
    )); ?>
<?php endif ?>
  
<div class='extra_padding'>
    <?php echo object_checkbox_tag($sf_guard_user, 'getEmailPrivate', array(
      'onblur'  => "$('information_msg').innerHTML='".__('**help-text when no field is selected**')."'",
      'onfocus' => "$('information_msg').innerHTML='".__('**help-text for hidden_email**')."'"
    )); ?>
    <?php echo wai_label_for('email_private', __('Keep my e-mail address hidden from other users'), array(
      'class'=>'normal_text',      
    )); ?> 
</div>
  
<?php echo wai_label_for('residence_id', __('Residence'));  //Residence?> 
<?php if($profile == 'create'): ?><span class="required_star">*</span><?php endif; ?><br />
<?php echo form_error('residence_id'); ?>
<?php if (!$sf_user->isAuthenticated()): ?>
  <?php echo select_tag('residence_id', options_for_select($residence_array, $sf_guard_user->getResidence(), array(    
    'include_custom' => __('Choose a residence'),
    'onblur'         => "$('information_msg').innerHTML='".__('**help-text when no field is selected**')."'",
    'onfocus'        => "$('information_msg').innerHTML='".__('**help-text for residence**')."'"
  ))); ?>
<?php else:?>
<?php  ?>
  <?php  echo select_tag('residence_id', options_for_select($residence_array, $sf_guard_user->getResidenceId(), array(     
     'onblur'  => "$('information_msg').innerHTML='".__('**help-text when no field is selected**')."'",
     'onfocus' => "$('information_msg').innerHTML='".__('**help-text for residence**')."'"
  ))); ?>
<?php endif; ?>

<br />
<?php if ($sf_guard_user->getDobIsDerived()): ?>
	<div class="message warning_box" style="width:370px;margin: 5px 0px;">
		<?php echo __("Your date of birth is incomplete"); ?>
	</div>
<?php endif; ?>
<?php echo wai_label_for('dob', __('Date of birth')); ?>
<?php if($profile == 'create'): ?><span class="required_star">*</span><?php endif; ?><br />
<?php echo form_error('dob'); ?>
<?php $date = $sf_guard_user->getDob(); ?>
<?php $date = $date ? $date : date(''); ?>       
<?php 
  echo input_date_tag('dob', $date, array(
  'rich'           => false, 
  'culture'        => $sf_user->getCulture(),  
  'year_start'     => date('Y'), 
  'year_end'       => date('Y')-sfConfig::get('app_profile_max_age',100),
  'date_seperator' => ' ',
  'include_custom' => array('day'=>__('Day'), 'month'=>__('Month'), 'year'=>__('Year'))
)); ?>

<?php if ($sf_guard_user->getDobIsDerived()): ?>
	<?php echo javascript_tag("
	  $('dob_month').value='';
	  $('dob_day').value='';
  ") ?>
<?php endif; ?>
   
<br />   
     
<?php echo wai_label_for('sex', __('Sex')); ?>
<?php if($profile == 'create'): ?><span class="required_star">*</span><?php endif; ?><br />
<?php echo form_error('sex'); ?>
<?php
    echo radiobutton_tag('sex', '1', $sf_guard_user->getSex()=='1', array(
     'onblur'  => "$('information_msg').innerHTML='".__('**help-text when no field is selected**')."'",
     'onfocus' => "$('information_msg').innerHTML='".__('**help-text for sex**')."'",
    ));
    echo wai_label_for('sex', __('male'), array('class'=>'normal_text'));
    
    echo radiobutton_tag('sex', '2', $sf_guard_user->getSex()=='2', array(
      'onblur'  => "$('information_msg').innerHTML='".__('**help-text when no field is selected**')."'",
      'onfocus' => "$('information_msg').innerHTML='".__('**help-text for sex**')."'",
    ));
    echo wai_label_for('sex', __('female'),array('class'=>'normal_text'));
?> 
<br /><br />
<?php if ($profile == "create"): ?>
  <?php echo wai_label_for("terms_and_conditions", __("Terms and conditions")); ?><br />
  <?php echo form_error("terms_and_conditions"); ?>
  <p class='extra_padding'>
    <?php echo checkbox_tag("terms_and_conditions","no",""
    ,array(
  'onblur'         => "$('information_msg').innerHTML='".__('**help-text when no field is selected**')."'",
  'onfocus'        => "$('information_msg').innerHTML='".__('**help-text for terms and conditions**')."'",

    )
    ); ?>
    <?php echo __("I have read and understood %link_to_terms_and_conditions%", 
            array("%link_to_terms_and_conditions%" => reaktor_link_to(__("the terms and conditions"), 
                  "@article?permalink=".sfConfig::get("app_fixed_articles_terms_and_conditions", "terms_and_conditions"), 
                  array("onmouseover" => "$('information_msg').innerHTML='".__('**help-text for terms and conditions**')."'",
                        "onmouseout"  => "$('information_msg').innerHTML='".__('**help-text when no field is selected**')."'",
                        "target" => "_blank"))));
    ?><span class="required_star">*</span>
  </p>
<?php endif; ?>
