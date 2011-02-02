<?php
/**
 * Functional test for translation of i18n tables
 * 
 * PHP Version 5
 *
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$nick = "userboy";
// create a new test browser
$b = new reaktorTestBrowser();
$b->initialize();

// Go to english frontpage
$b->get("/en"); 
$b->isStatusCode(200);
$b->isRequestParameter('module', 'home');
$b->isRequestParameter('action', 'index');

$b->checkResponseElement("div#menu_bar", '/Photo/');

// The subreaktor class is caching some stuff, and since symfony test doesn't really reload or 
// refresh, we need to clear the cached stuff
Subreaktor::clear();

// Go to norwegian frontpage, should have different subreaktor headers
$b->get("/no"); 
$b->isStatusCode(200);
$b->isRequestParameter('module', 'home');
$b->isRequestParameter('action', 'index');

$b->checkResponseElement("div#menu_bar", '/Foto/');

?>