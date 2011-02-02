<?php
/**
 * Functional test for composite artwork, selecting files
 * 
 * PHP Version 5
 *
 * @author    Hannes Magnusson <bjori@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$b = new reaktorTestBrowser();
$b->initialize();

// Make sure this page is not accessible by regular joes
$b
  ->get("/en/admin/artwork/createcomposite")
  ->responseContains("You need to log in to view this page, please use the login form to the right.")
  ->login("userboy", "userboy", "/en/admin/artwork/createcomposite")
  ->responseContains("You don't have the requested permission to access this page.")
;

// Admin can
$b
  ->login("admin", "admin", "/en/admin/artwork/createcomposite")
  ->isStatusCode(200)
  ->isRequestParameter("module", "admin")
  ->checkResponseElement("h1", "*Create a new composite artwork*")
;

// Get all images tagged with car, russ or abigail
$b
  ->setField("tags_check", 1)
  ->setField("tags", "car, russ, abigail")
  ->click("Find files")
  ->isStatusCode(200)
;

// Two of those, one russ and one abigail
$b
  ->checkResponseElement("ul#composite_artwork_filelist", true)
  ->checkResponseElement("ul#composite_artwork_filelist li", "*Filming in Saudi*")
  ->checkResponseElement("ul#composite_artwork_filelist li#file_8", "*Abigail at Frogner*")
;

// russ images from January 1st to 2nd 2007 
$b
  ->setField("tags", "russ, abigail")
  ->setField("date_check", 1)
  ->setField("from_date", array(
    "day"   => 01,
    "month" => 01,
    "year"  => 2007,
    )
  )
  ->setField("to_date", array(
    "day"   => 02,
    "month" => 01,
    "year"  => 2007,
    )
  )
  ->click("Find files")
;

// And that is Russ filming ing saudi arabia, not abigail
$b
  ->checkResponseElement("ul#composite_artwork_filelist", true)
  ->checkResponseElement("ul#composite_artwork_filelist li", "*Filming in Saudi*")
  ->checkResponseElement("ul#composite_artwork_filelist li#file_8", false)
;


// Using the same search elements, changing images not whatever else should fail
$b
  ->setField("filetype", "audio")
  ->click("Find files")
  ->checkResponseElement("ul#composite_artwork_filelist", false)
  ->checkResponseElement("div#composite_file_list", "*Could not find any files based on your criteria*")
;

$b
  ->setField("filetype", "pdf")
  ->click("Find files")
  ->checkResponseElement("ul#composite_artwork_filelist", false)
  ->checkResponseElement("div#composite_file_list", "*Could not find any files based on your criteria*")
;

$b
  ->setField("filetype", "text")
  ->click("Find files")
  ->checkResponseElement("ul#composite_artwork_filelist", false)
  ->checkResponseElement("div#composite_file_list", "*Could not find any files based on your criteria*")
;


// Clear the page
$b->get("/en/admin/artwork/createcomposite");

// Make sure the text search works too :)
$b
  ->setField("date_check", 1)
  ->setField("from_date", array(
    "day"   => 01,
    "month" => 01,
    "year"  => 2007,
    )
  )
   ->setField("to_date", array(
    "day"   => 01,
    "month" => 12,
    "year"  => 2008,
    )
  )
  ->setField("filetype", "text")
  ->click("Find files")
;

// That should find "Random plain text"
$b
  ->checkResponseElement("ul#composite_artwork_filelist", true)
  ->checkResponseElement("ul#composite_artwork_filelist li", "*Random plain text*")
;



