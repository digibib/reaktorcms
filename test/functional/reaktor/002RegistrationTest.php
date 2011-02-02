<?php
/**
 * This test covers:
 * 
 * Testing validation of each field
 * 
 * PHP version 5
 *
 * @author Russ Flynn, juneih, olepw
 * @copyright 2008 Linpro
 * @license http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * 
 * TODO: Change tests that involve checkResponseElement to match against 
 * smaller DOMs/ids after userRegFormSuccess has been styled.
 * TODO: Check if email is sent when registering a user
 * TODO: Test activation code sent when a user registers
 * TODO: Test getting a new password
 * 
 */
include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$browser = new reaktorTestBrowser();
$browser->initialize();
$browser->
  get('/en/register')->
  isStatusCode(200)->
  isRequestParameter('module', 'profile')->
  isRequestParameter('action', 'register')->
  checkResponseElement('h1', '*Register as a user*')->
  //this checks that the config files are working
  checkResponseElement('h2#information_msg', '/\*\*help-text when no field is selected\*\*/')
;

//The fieldinformation we are going to test
$fields['username']        = array('username_profile', 'must enter a username', 'test');
$fields['password']        = array('password_profile', 'choose a password', 'testdummy');
$fields['password_repeat'] = array('password_repeat','must type the password twice', 'test');
$fields['email']           = array('email', 'enter an email address', 'reaktor-functest@linpro.no');
$fields['sex']			       = array('sex','Please choose your sex','1');
$fields['residence']       = array('residence_id', 'choose where your residence is', 1);
$fields['dob']             = array('dob', 'choose the date you were born', null);
$fields['terms_and_conditions'] = array('terms_and_conditions', 'must indicate that you have read and understood the terms', 1);

//First we click the register button with empty fields and check that the validation works
$browser->click('Register me');
foreach($fields as $field)
{
  $browser->checkResponseElement('div.profile_left', '*'.$field[1].'*');
}

//Now we enter all details but for one field to check that the fields we do fill in don't display validation messages
foreach($fields as $field)
{
  if($field[2]!= null)
  {
    $browser->setField($field[0], $field[2]);    
  }  
}
$browser->click('Register me');
foreach($fields as $field)
{
  if($field[2]!= null)
  {
    $browser->checkResponseElement('div.profile_left', '!/'.$field[1].'/');   
  }  
}

//We do the same test but for the date of birth multi field, populate only date of birth fields
$browser->
  get('/en/register')->
  setField('dob[day]', 1)->
  setField('dob[month]', 1)->
  setField('dob[year]', 1999)->
  click('Register me');
//check that all but dob field is validated
foreach($fields as $field)
{
  if($field[2]!= null)
  {
    $browser->checkResponseElement('div.profile_left', '*'.$field[1].'*');
  }
  else
  {
    $browser->checkResponseElement('div.profile_left', '!/choose the date you were born/');
  }
}

//Populate password and password_repeat field with different passwords
$browser->
  setField($fields['password'][0], $fields['password'][2])->
  setField($fields['password_repeat'][0], $fields['password_repeat'][2])->
  click('Register me')->
  checkResponseElement('div.profile_left', '*passwords do not match*');

//test #48 - do an actual registration
$fields['password_repeat'][2] = $fields['password'][2]; 

//populate all the fields
foreach($fields as $field)
{
  if($field[2]!= null)
  {
    $browser->setField($field[0], $field[2]);    
  }  
}
$browser->
  setField('dob[day]', 1)->
  setField('dob[month]', 1)->
  setField('dob[year]', 1999)->
  setField('recaptcha_response_field', '1234567')-> # the CAPTCHA field is required, but not verified for tests
  click('Register me');

//check the validation form hasn't kicked in again
foreach($fields as $field)
{
  $browser->checkResponseElement('div.profile_left', '!/'.$field[1].'/');
}

$browser->checkResponseElement('div#content_main h1', '*Registration successful*');

//register the same user twice
$browser->get('/en/register');
//populate all the fields and check the user has been added
foreach($fields as $field)
{
  if($field[2]!= null)
  {
    $browser->setField($field[0], $field[2]);    
  }  
}
$browser->
  setField('dob[day]', 1)->
  setField('dob[month]', 1)->
  setField('dob[year]', 1999)->
  setField('recaptcha_response_field', '1234567')-> # the CAPTCHA field is required, but not verified for tests
  click('Register me')->
  checkResponseElement('div.profile_left','*This email is already in use*')->
  checkResponseElement('div.profile_left','*This username is already in use*');
 
//
//Activate account - here we need to cheat a little-. We're getting the activation code directly from the database
//
$con = Propel::getConnection();

$c = new Criteria();
$c->add(sfGuardUserPeer::IS_VERIFIED, 0);
$c->addDescendingOrderByColumn('id');

$db_user = sfGuardUserPeer::doSelectOne($c);

$browser->
  get('/en/profile/activate/key/'.$db_user->getSalt())->
  checkResponseElement('div#content_main h1', '*Activation successful*');

