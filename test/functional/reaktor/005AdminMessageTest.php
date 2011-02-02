<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$b = new sfTestBrowser();
$b->initialize();
$b->get('/');
$b->setField('password', 'admin');
$b->setField('username', 'admin');
$b->click('Sign in');
$b->isRedirected()->followRedirect();

$b->get('/no/admin/message');
$b->checkResponseElement("div#sidebar", "*System has been updated!*");
$b->click('delete');
$b->checkResponseElement("div#sidebar", "!/System has been updated!/");

$b->get('/no/admin/message/create');
$b->setField('admin_message[message]', 'eat my monkeydust');
$b->setField('admin_message[expires_at]', '23.05.2011 14.43');
$b->setField('id', '');

$b->click('save');


$b->get('/no/admin/message');
$b->checkResponseElement("div#sidebar", "*eat my monkeydust*");

$b->click('edit');
$b->setField('admin_message[message]', 'eat my new monkeydust');
$b->click('save');

$b->get("/");
$b->checkResponseElement("div#sidebar", "*eat my new monkeydust*");