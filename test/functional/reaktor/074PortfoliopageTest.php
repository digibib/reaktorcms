<?php
/**
 * Functional test for comment listing by date/user
 * Also tests pagination to an extent, may break after some tweaking is done to this
 * 
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$nick = "userboy";
// create a new test browser
$b = new reaktorTestBrowser();
$b->initialize();

// Try to be here without specifying a file
$b->get("/en/portfolio/". $nick); 
$b->isStatusCode(200);
$b->isRequestParameter('module', 'profile');
$b->isRequestParameter('action', 'portfolio');

//We should be presented with a login message, since this page is only ever for logged in users
$b->checkResponseElement("div.portfolio_header_wrapper", "*userboy's portfolio*");
$b->checkResponseElement("div#content_main", "*The fancy gallery*");
$b->responseContains("default.gif");
$b->checkResponseElement("div#content_main", "!/Logged in/");
$b->setField('password', $nick);
$b->setField('username', $nick);
$b->click('Sign in');
$b->isRedirected()->followRedirect();
$b->checkResponseElement("div#content_main", "*This user is currently online*");

?>
