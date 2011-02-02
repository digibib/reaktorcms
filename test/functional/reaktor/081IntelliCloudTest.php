<?php
/**
 * Test for intelligent tag clouds on artwork display page
 *
 * PHP Version 5
 *
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
define("NO_CLEAR", true);
include(dirname(__FILE__).'/../../bootstrap/functional.php');

$b = new reaktorTestBrowser();
$b->initialize();

$b->get("/no/artwork/show/2/The+fancy+gallery");

// #1-3
$b->isStatusCode();
$b->isRequestParameter('module', 'artwork');
$b->isRequestParameter('action', 'show');

// #4 Check the tag cloud block exists - good for debugging when/if the following tests fail
$b->checkResponseElement('div#artwork_right_container .tag-cloud-right');

// #5-14 Check the cloud at least contains the tags that this artwork is tagged with
//       Includes file objects that are attached to the artwork
//       We should set a limit so we don't exceed the tag cloud capacity

$artwork = new genericArtwork(2);
$tags    = $artwork->getTags(true);
$i       = 1;

foreach ($tags as $tag)
{
  $b->checkResponseElement('div#artwork_right_container .tag-cloud-right', '/'.$tag.'/');
  if (++$i > 10)
  {
    break;
  }
}

// #15-18 Now we should check that some related tags are showing
//     The logic behind the returned tags should be dealt with in unit tests and QA - there is no point
//     testing them, other that the results of the logic display on the page

// The following have been manually taken from the results based on the fixtures, to save time
// If these tests fail it is because the tag fixtures have changed, and this test needs to be updated

$b->checkResponseElement('div#artwork_right_container .tag-cloud-right', '/wildlife/');
$b->checkResponseElement('div#artwork_right_container .tag-cloud-right', '/gardening/');
$b->checkResponseElement('div#artwork_right_container .tag-cloud-right', '/car/');
$b->checkResponseElement('div#artwork_right_container .tag-cloud-right', '/park/');

// #19-22 Lets check a link to see if they are being generated correctly
$b->click("wildlife");
$b->isStatusCode();
$b->isRequestParameter('module', 'tags');
$b->isRequestParameter('action', 'find');
$b->checkResponseElement('div#content_main h2', '*Work tagged with wildlife*');
