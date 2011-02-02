<?php
/**
 * Functional tests for user story 25 - User adminstration.
 * This test covers:
 * 
 * Checking that permissions are set for user administration
 * Test that validation is set for username, password, residence
 * TODO: date selector is acting up, and doesn't want to be set...:(
 * 
 *
 * PHP version 5
 *
 * @author juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$b = new sfTestBrowser();
$b->initialize();

//Check if functionality is protected for users not logged in
$b->get('/sfGuardUser/list');
$b->responseContains("You need to log in");


//Check if functionality is protected for logged in users without access
$b->setField('username', 'userboy');
$b->setField('password', 'userboy');
$b->click('sign in');

$b->get('/sfGuardUser/list');
$b->responseContains("You don't have the requested permission");
$b->get('/logout');

// Log in as user with access 
$b->get('/');
$b->setField('username', 'admin');
$b->setField('password', 'admin');
$b->click('sign in');

//
//Create user
//
$b->get('/sfGuardUser/create');
$b->isStatusCode(200);
$b->isRequestParameter('module', 'sfGuardUser');
$b->isRequestParameter('action', 'create');

//Test validation
$fields['username']  = array('sf_guard_user[username]', 'enter a username', 'test');
$fields['password']  = array('sf_guard_user[password]', 'Password is mandatory', 'testdummy');
$fields['residence'] = array('sf_guard_user[residence_id]', 'Required', '6');
$fields['dob']       = array('', 'enter a valid date of birth');

$b->click('Save and continue editing');
//$b->setField('sf_guard_user[dob]', '2000-01-01');
/*$b->setField('sf_guard_user[dob][day]', '1');
$b->setField('sf_guard_user[dob][month]', '1');
$b->setField('sf_guard_user[dob][year]', '2000');*/
foreach ($fields as $field)
{ 	
    $b->responseContains($field[1]);
}
array_pop($fields);
//print_r($fields);
//$fields[] = array('sf_guard_user_dob_day', 'date you entered is not valid', '1');
//$fields[] = array('sf_guard_user[dob][month]', 'date you entered is not valid', '1');
//$fields[] = array('sf_guard_user[dob][year]', 'date you entered is not valid', '2000');

foreach ($fields as $field)
{  
  $b->setField($field[0], $field[2]);
  $b->click('Save and continue editing');  
  $b->checkResponseElement('div.form-row', '!/'.$field[1].'/');
}


/*
//Check that password do not match validation works
$fields['password_repeat'] = array('sf_guard_user[password_bis]','do not match', 'notdummy');
$b->setField($fields['password'][0], $fields['password'][2]);
$b->setField($fields['password_repeat'][0], $fields['password_repeat'][2]);
$b->click('Save and continue editing');
$b->responseContains($fields['password_repeat'][1]);

//
//Create user by filling in the rest of the form
//
/*
$b->setField($fields['password'][0], $fields['password'][2]);
$b->setField($fields['password_repeat'][0], $fields['password'][2]);
$b->setField('sf_guard_user[sex]', '2');
//$b->setField('sf_guard_user[dob]', '2000-01-01');
$b->setField('sf_guard_user[dob][day]', '1');
$b->setField('sf_guard_user[dob][month]', '1');
$b->setField('sf_guard_user[dob][year]', '2000');
$b->click('Save and continue editing');
$b->checkResponseElement('div.form-row', '!/'.$fields['password_repeat'][1].'/');


