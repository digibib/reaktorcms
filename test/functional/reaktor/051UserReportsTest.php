<?php
// FAIL: This test fails due to fixture problems, editorialboy1 should have 
// staff priv
/**
 * Userbased report tests
 *
 * PHP version 5
 *
 * @author    Hannes Magnusson <bjori@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */ 

include(dirname(__FILE__).'/../../bootstrap/functional.php');

function selectAndPick(sfTestBrowser $t, array $options)
{
  # Loop over the options as select the options, and their _check options
  foreach($options as $check => $value)
  {
    $t->setField($check . "_check", 1);
    $t->setField($check, $value);
  }

  return $t;
}
function deSelect(sfTestBrowser $t)
{
  $args = func_get_args();
  array_shift($args);
  foreach($args as $option)
  {
    $t->setField($option. "_check", 0);
  }
  return $t;
}
function select(sfTestBrowser $t)
{
  $args = func_get_args();
  array_shift($args);
  foreach($args as $k => $v)
  {
    if (is_array($v))
    {
      $t->setField(key($v), current($v));
    }
    else
    {
      $t->setField($v, 1);
    }
  }
}

define("STATS", 1);
define("USERLIST", 2);

function generate(sfTestBrowser $t, $what)
{
  $t->setField("report_type", $what);
  $t->click("Generate report");
  return $t;
}
function checkResults(sfTestBrowser $t, array $users)
{
  generate($t, STATS)->checkResponseElement("div#result_div", "/Number of hits: ". count($users) . "/");
  generate($t, USERLIST);

  foreach($users as $username) {
    $t->checkResponseElement("div#result_div", "/$username/");
  }
}

// create a new test browser
$b = new reaktorTestBrowser();
$b->initialize();

$BASE = "/en/admin/reports/user";
//We start by confirming that the page doesnt show when not logged in
$b->get($BASE)->isStatusCode(200)
  ->checkResponseElement('div#secure_notice', '/You need to log in to view this page, please use the login form to the right/');
  

//Log in as a non-admin user, and confirm the page doesn't show 
$b->login("monkeyboy", "monkeyboy", $BASE)
  ->checkResponseElement('div#content_main', "/You don't have the requested permission to access this page./");

//Confirm that page shows when logged in with correct credentials
$b->login("editorialboy1", "editorialboy1", $BASE)
  ->checkResponseElement('div#query_generator h1', '/Generate custom user report/');
  
// Males from Finnmark
selectAndPick($b, array(
  "residence" => 4, # Finnmark
  "sex"       => 1, # Male
));
// Only monkeyboy
checkResults($b, array("monkeyboy"));

// Females from Finnmark
selectAndPick($b, array(
  "sex" => 2, # Female
));
// Only leo
checkResults($b, array("leo"));

// Pick whichever sex
deSelect($b, "sex");

// Only users who have published artwork
select($b, "publishedArtwork");
// Which is only monkeyboy
checkResults($b, array("monkeyboy"));

// And
select($b, "commentAndOr");

// Has not commented
select($b, "notCommentedArtwork");

// Which is noone
checkResults($b, array()); 

// Reset the form
$b->get($BASE);


selectAndPick($b, array(
  "sex" => 1, # Male
));
// All males
checkResults($b, array("monkeyboy", "userboy", "languageboy", "editorialboy1", "editorialboy2", "editorialboy3", "articleboy", "veteran"));
// That have published artworks
select($b, "publishedArtwork");
checkResults($b, array("monkeyboy", "userboy"));

// Sexchange
selectAndPick($b, array(
  "sex" => 2, # Female
));
checkResults($b, array("admin", "Kerry", "dave")); # Yes, dave and admin are chicks


$b->get($BASE);
// Get all users registered from 5mars to 6th mars
select($b, "startDateArr_check", array("startDateArr[day]" => 5), array("startDateArr[month]" => 3), array("startDateArr[year]" => 2008));
select($b, "endDateArr_check", array("endDateArr[day]" => 6), array("endDateArr[month]" => 3), array("endDateArr[year]" => 2008));
checkResults($b, array("admin", "monkeyboy", "userboy", "leo"));

// Which are females
selectAndPick($b, array(
  "sex" => 2, # Female
));
checkResults($b, array("admin", "leo"));


