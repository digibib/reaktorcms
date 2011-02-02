<?php
/**
 * The user should be able to have printable reaktor pages where the layout has been stripped for
 * sidebars, menus, etc. This is done with a separate CSS, loaded when the user is printing. 
 * Without making additional functionality for functional testing purposes only, this is impossible 
 * to test using sfTestbrowser. The functional testing for this story is thus, cramped. 
 * However, if we in the future might need want further testing on this: this function might help:
 * $this->getContext()->getResponse()->addStylesheet('css/print');
 *  
 * These functional tests cover:
 * 
 * - Check for print button on the artwork page.
 * 
 *
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */


include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$b = new sfTestBrowser();
$b->initialize();
$b->get('/no/artwork/show/2/The+fancy+gallery')
  ->isStatusCode(200)
  ->checkResponseElement('div#socialBookmarks', '/Print/');

?>