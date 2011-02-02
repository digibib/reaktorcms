<?php
// FAIL: This test fails due to fixture problem
/**
 * There are always a lot of useful information in statistics, and along with the user,
 * the artwork is one of the most important objects in reaktor, in which you can retrieve
 * a lot of useful information. This functional tests the report where you can extract the 
 * most importan information on Artworks.
 * 
 * This functional test covers:
 * -  
 *
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */ 

include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$b = new reaktorTestBrowser();
$b->initialize();

//We start by confirming that the page doesnt show when not logged in
$b->get('/en/admin/reports/artwork')->isStatusCode(200)
  ->checkResponseElement('div#secure_notice', '/You need to log in to view this page, please use the login form to the right/');
  

//Log in as a non-admin user, and confirm the page doesn't show 
$b->setField('username', 'monkeyboy')
  ->setField('password','monkeyboy')
  ->click('Sign in')
  ->isRedirected()
  ->followRedirect()
  ->checkResponseElement("div#user_summary .nickname", "monkeyboy")
  ->get('/en/admin/reports/artwork')->isStatusCode(200)
  ->checkResponseElement('div#content_main', "/You don't have the requested permission to access this page./");

//Log out and log in as a staff member
$b->click('Log out')
  ->isRedirected()
  ->followRedirect()
  ->setField('username', 'editorialboy1')
  ->setField('password','editorialboy1')
  ->click('Sign in')
  ->followRedirect()
  ->checkResponseElement('div#user_summary .nickname', 'editorialboy1');

//Confirm that page shows when logged in with correct credentials
$b->get('/en/admin/reports/artwork')
  ->responseContains("Generate new artwork report");
//->checkResponseElement('div#query_generator h1', '/Generate new artwork report/');
  
//Find all artworks in foto subreaktor
$b->setField('subreaktor_check', 1)
  ->setField('subreaktor_id', 1)
  ->click('Generate report')
  ->checkResponseElement('div#query_results', '/Number of artworks/');
      
//Find all artworks tagged with animal and display as artwork list
$b->get('/en/admin/reports/artwork')
  ->setField('category_check', 1)
  ->setField('category_id', 3)
  ->setField('report_type', 2)
  ->click('Generate report')
  ->checkResponseElement('div#query_results', '/Artwork matching your query/')
  ->checkResponseElement('div#query_results', '/Cute monkeys/');

//Find all artworks tagged with 'fluffy' display as artwork list 
$b->get('/en/admin/reports/artwork')
  ->setField('tags_check', 1)
  ->setField('tags', 'fluffy')
  ->setField('report_type', 2)
  ->click('Generate report')
  ->checkResponseElement('div#query_results', '/Artwork matching your query/')
  ->checkResponseElement('div#query_results', '/Nice monkeys/')
  ->checkResponseElement('div#query_results', '/The fancy gallery/');

//Find all artworks approved by Groruddalen editorial team, display as list  
$b->get('/en/admin/reports/artwork')
  ->setField('editorial_team_check', 1)
  ->setField('editorial_team_id', 9)
  ->setField('report_type', 2)
  ->click('Generate report')
  ->checkResponseElement('div#query_results', '/The wonderful painting/')
  ->checkResponseElement('div#query_results', '/My Pdf/');
  
//Find all artworks approved by editorialboy1, display statistics 
$b->get('/en/admin/reports/artwork')
  ->setField('editorial_team_member_check', 1)
  ->setField('editorial_team_member_id', 8)
  ->setField('report_type', 1)
  ->click('Generate report')
  ->checkResponseElement('div#query_results', '/Number of artworks/')
  ->checkResponseElement('div#query_results', '/0 unique artworks matching your query/');
  
//Find all unapproved artworks, display statistics 
$b->get('/en/admin/reports/artwork')
  ->setField('status_check', 1)
  ->setField('status_value', 2)
  ->setField('report_type', 1)
  ->click('Generate report')
  ->checkResponseElement('div#query_results', '/Number of artworks/')
  ->checkResponseElement('div#query_results', '/4 unique artworks matching your query/');

//Find all artworks under discussion
$b->get('/en/admin/reports/artwork')
  ->setField('under_discussion_check', 1)
  ->setField('report_type', 1)
  ->click('Generate report')
  ->checkResponseElement('div#query_results', '/Number of artworks/')
  ->checkResponseElement('div#query_results', '/1 unique artworks matching your query/');

//Find all artworks approved in march 2008
$b->get('/en/admin/reports/artwork')
  ->setField('from_date_check', 1)
  ->setField('from_date[day]', 1)
  ->setField('from_date[month]', 3)
  ->setField('from_date[year]', 2008)
  ->setField('to_date_check', 1)
  ->setField('to_date[day]', 31)
  ->setField('to_date[month]', 3)
  ->setField('to_date[year]', 2008)
  ->setField('report_type', 1)
  ->click('Generate report')
  ->checkResponseElement('div#query_results', '/Number of artworks/')
  ->checkResponseElement('div#query_results', '/Average waiting time before approval/')
  ->checkResponseElement('div#query_results', '/3 unique artworks matching your query/');
 
//Try a combination: all approved artworks in march, in category travel, approved by photo editorial team, by staff user admin
$b->get('/en/admin/reports/artwork')
  ->setField('subreaktor_check', 1)
  ->setField('subreaktor_id', 1)
  ->setField('category_check', 1)
  ->setField('category_id', 12)
  ->setField('editorial_team_check', 1)
  ->setField('editorial_team_id', 5)
  ->setField('editorial_team_member_check', 1)
  ->setField('editorial_team_member_id', 1)
  ->setField('status_check', 1)
  ->setField('status_value', 3)
  ->setField('from_date_check', 1)
  ->setField('from_date[day]', 1)
  ->setField('from_date[month]', 3)
  ->setField('from_date[year]', 2008)
  ->setField('to_date_check', 1)
  ->setField('to_date[day]', 31)
  ->setField('to_date[month]', 3)
  ->setField('to_date[year]', 2008)
  ->setField('report_type', 1)
  ->click('Generate report')
  ->checkResponseElement('div#query_results', '/Number of artworks/')
  ->checkResponseElement('div#query_results', '/1 unique artworks matching your query/');

//Check out links to top saved artwork reports
$b->get('/en/admin/reports/artwork')
  ->checkResponseElement('div#savedReportsBox', '/Top saved artwork reports/')
  ->click('Stats', 'All approved stats')
  ->checkResponseElement('div#query_results', '/Number of artworks/')
  ->click('List', 'All rejected list') 
  ->checkResponseElement('div#query_results', '/Artwork matching your query/');
  
//Check the list link in the this report 
$b->click('List', 'This report - All rejected list') 
  ->checkResponseElement('div#query_results', '/Artwork matching your query/');
  
?>
