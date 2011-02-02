<?php
/**
 * Subreaktor tests
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$b = new reaktorTestBrowser();
$b->initialize();

// create a new test browser
$b = new reaktorTestBrowser();
$b->initialize();

$b->get("/no/admin/list/subreaktors");

/* #1-3 */
$b->isStatusCode(200);
$b->isRequestParameter('module', 'subreaktors');
$b->isRequestParameter('action', 'list');

/* #4 We should be presented with a login message, since this page is only ever for logged in users */
$b->checkResponseElement("div#content_main", "*You need to log in*");

//Lets log in - this user should always exist in test db
$b->setField('password', 'admin');
$b->setField('username', 'admin');
$b->click('Sign in');
$b->followRedirect();

/* #5-6 Now we should be presented with the Subreaktor list page, if all went well */
$b->checkResponseElement("div#content_main", "/Add a new subReaktor/");
$b->checkResponseElement("div#content_main", "/Current subReaktors/");

/* #7-8 Lets check some of the standard subreaktors */
$b->checkResponseElement("ul#subreaktor_list", "/Foto/");
$b->checkResponseElement("ul#subreaktor_list", "/Film\/animasjon/");

/* #9-10 We can also check that the Foto Reaktor is first based on the ordering, 
         since this will only check the first instance of the class */
$b->checkResponseElement("ul#subreaktor_list li.subreaktor_list", "/Foto/");
$b->checkResponseElement("ul#subreaktor_list li.subreaktor_list", "!/Tegning\/graffikk/");

// Lets make the Foto reaktor "not live" and check it's status on this page
// We can also change the order of Foto and check that Tegning/graffikk has moved to the top

$fotoReaktor = SubreaktorPeer::retrieveByPK(1);
echo "Foto reaktor order was ".$fotoReaktor->getSubreaktorOrder();
$fotoReaktor->setLive(0);
$fotoReaktor->setSubreaktorOrder(2);
$fotoReaktor->save();

$tegningReaktor = SubreaktorPeer::retrieveByPK(2);
echo "Tegning reaktor order was ".$tegningReaktor->getSubreaktorOrder();
$tegningReaktor->setSubreaktorOrder(1);
$tegningReaktor->save();

echo "Foto reaktor order is now ".$fotoReaktor->getSubreaktorOrder();
echo "Tegning reaktor order is now ".$tegningReaktor->getSubreaktorOrder();

// The subreaktors most be repopulated when changed, or the old cached instance will be used
Subreaktor::_populateSubReaktors();

// Lets reload the page
$b->reload();

/* #11-12 Now photo should not be the first list element, Tegning should be */
$b->checkResponseElement("ul#subreaktor_list li.subreaktor_list", "!/Foto/");
$b->checkResponseElement("ul#subreaktor_list li.subreaktor_list", "/Tegning\/grafikk/");

/* #13 Foto should also be marked "not live" now, since we changed that above too */
$b->checkResponseElement("li#subreaktor_1", "/not live/");

/* #14-15 Lets check the "not live" status by logging out and trying to access */
$b->click("Log out");
$b->isRedirected()->followRedirect();
$b->get("/en/foto");
$b->isStatusCode(404);

/* #16  We should still be able to see it if we are admin though */
$b->setField('password', 'admin');
$b->setField('username', 'admin');
$b->click('Sign in');
$b->followRedirect();
$b->get("/en/foto");
$b->isStatusCode(200);

/* #17-18 Lets try to create a new subreaktor without entering any data */
$b->get("/en/admin/list/subreaktors");
$b->click("Create");
$b->checkResponseElement("div#error_for_name", "/You must/");
$b->checkResponseElement("div#error_for_reference", "/You must/");

/* #19-20 Lets fill only name field */
$b->setField("name", "fred");
$b->click("Create");
$b->checkResponseElement("div#error_for_name", "!/You must/");
$b->checkResponseElement("div#error_for_reference", "/You must/");

/* #21-22 Lets try to use weird characters in ref field */
$b->setField("reference", "@£[");
$b->click("Create");
$b->checkResponseElement("div#error_for_name", "!/You must/");
$b->checkResponseElement("div#error_for_reference", "/Please use only alphanumeric characters /");

/* #23 lets use some real data */
$b->setField("name", "Fred Reaktor");
$b->setField("reference", "fred");
$b->click("Create");
$b->isRedirected()->followRedirect();

/* Possible problems here involve write access to folders which may throw up errors - if test fails after this point
   Check the write permissions on /apps/reaktor/modules/subreaktors/templates and /web/images */

/* #24 Check we have a newly created subreaktor for editing */
$b->checkResponseElement("body", "/Edit Fred Reaktor subReaktor/");

/* #25-28 Lets check the drop downs */
$b->responseContains('<select name="subreaktor_live" id="subreaktor_live"><option value="1">Yes</option>');
$b->responseContains('<select name="subreaktor_lokalreaktor" id="subreaktor_lokalreaktor"><option value="1">Yes</option>');
$b->setField("subreaktor_live", 1);
$b->setField("subreaktor_lokalreaktor", 0); //1 for lokalreaktor

$b->click("Update subReaktor");
$b->followRedirect();
$b->responseContains('<select name="subreaktor_live" id="subreaktor_live"><option value="1" selected="selected">Yes</option>');
//$b->responseContains('<select name="subreaktor_lokalreaktor" id="subreaktor_lokalreaktor"><option value="1" selected="selected">Yes</option>');

/* The rest is ajax so we should just put some data into the database and test the correct display
 * First lets get the recently created subreaktor so we can modify it */

$c = new Criteria();
$c->addDescendingOrderByColumn(SubreaktorPeer::ID);
$fredReaktor = SubreaktorPeer::doSelectOne($c);

/* #29-30 Add some categories and check they appear correctly */
$fredReaktor->addCategory(1);
$fredReaktor->addCategory(2);
$b->reload();
$b->checkResponseElement("div#categoryList", "/architecture/");
$b->checkResponseElement("div#categoryList", "/children/");

/* #31-32 Delete one of them and check it has gone */
$fredReaktor->deleteCategory(1);
$fredReaktor->save();

$b->reload();
$b->checkResponseElement("div#categoryList", "!/architecture/");
$b->checkResponseElement("div#categoryList", "/children/");

/* #33-35 Same tests with file types */
$fredReaktor->addFileType("image");
$fredReaktor->addFileType("pdf");
$b->reload();
$b->checkResponseElement("div#subreaktorFiletypes", "/image/");
$b->checkResponseElement("div#subreaktorFiletypes", "/pdf/");

$fredReaktor->deleteFileType("image");
$b->reload();
$b->checkResponseElement("div#subreaktorFiletypes", "!/image/");
$b->checkResponseElement("div#subreaktorFiletypes", "/pdf/");

/**
 * Would like to test the menu but can't get it working here, even though it's fine on the site 
 * 
*/

// Perform cleanup
unlink(realpath(dirname(__FILE__).'/../../../apps/reaktor/modules/subreaktors/templates/fredReaktorSuccess.php'));
unlink(realpath(dirname(__FILE__).'/../../../web/images/logoFred.gif'));

/* Lets load up some subreaktor pages, and check that the components are behaving */
$b->get("/en/foto");

/* #36 ---> Check the category list */
$fotoReaktor = Subreaktor::getByReference("foto");
$categories  = Subreaktor::listSubcategories($fotoReaktor);

foreach ($categories as $category => $count)
{
  $b->checkResponseElement("div#top_block_right", "/".$category."/"); 
}

/* Check the tag cloud of a different subreaktor */
Subreaktor::clear();

$b->get("/en/film");

$filmReaktor = Subreaktor::getByReference("film");
$tags = TagPeer::getPopularTagsWithCount(sfConfig::get("app_home_max_tags", 5), sfConfig::get("app_home_max_tag_length", 500), $filmReaktor);

foreach ($tags as $tag)
{
  $b->checkResponseElement("body", "/".$tag["displayName"]."/");
}

/* Lets do some basic tests for the most popular, latest comments and new users sections 
   Had enough of this test now, so will rely on the fixtures in some of the reaktors*/

Subreaktor::clear();
$b->get("/en/foto");

// Most popular
$b->checkResponseElement("div.list_block_wrapper", "/The fancy gallery/");

// Latest comments
$b->checkResponseElement("div.list_block_wrapper", "/huh\?/");
$b->checkResponseElement("div.list_block_wrapper", "/Sheesh/");

$user = sfGuardUserPeer::retrieveByUsername("userboy");
$user->setLastActive(time()- 1000);
$user->save();

//New users
$b->reload();
$b->checkResponseElement("div.list_block_wrapper", "/userboy/");

Subreaktor::clear();
$b->get("/en/tekst");

// Spam test - SHOULD NOT show on page since it's unnapproved
$b->checkResponseElement("div.list_block_wrapper", "!/C1alis at net prices/");

// Latest comments
$b->checkResponseElement("div.list_block_wrapper", "/I hate Colin/");
$b->checkResponseElement("div.list_block_wrapper", "/Huh\?/");

/* One last test - users that are not verified should not be on the new users list */
Subreaktor::clear();
$b->get("/en/foto");
// Check that what we are testing below is valid
$b->checkResponseElement("div.list_block_wrapper", "/userboy/");


$user->setIsActive(0);
$user->setIsVerified(0);

$user->save();
$b->reload();

// User should not appear now
$b->checkResponseElement("div.list_block_wrapper", "!/userboy/");

