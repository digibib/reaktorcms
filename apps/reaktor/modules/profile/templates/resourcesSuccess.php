<?php
/**
 * A user can store resources he/she uses often. 
 * 
 * This is really just a component, but we need to validate the form, which is why this dummy template
 * is needed.
 * 
 * The controller passes the following information:
 * 
 * $user - The id of the user 
 */

include_component('profile', 'resources', array('user' => $user));

?>