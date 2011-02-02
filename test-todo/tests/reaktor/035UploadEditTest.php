<?php
/**
 * Test script for login form
 * 
 * Covers:
 *  Submitting empty field
 *  Database creation of upload
 *  Correct messages when linking to existing
 *  Logged in status
 * 
 * Does not cover:
 *  Verifying the transcoding process (if applicable)
 *  Client side validation
 * 
 * PHP version 5
 * 
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$b = new sfTestBrowser();
$b->initialize();

// Try to be here without specifying a file
$b->get("/upload/edit"); 
$b->isStatusCode();
$b->isRequestParameter('module', 'upload');
$b->isRequestParameter('action', 'edit');

//We should be presented with a login message, since this page is only ever for logged in users
$b->checkResponseElement("div#content_main", "*You need to log in*");

// Get an object that belongs to a normal user to work with from the database
// Lets start with an image object so we can test that users can't change thumbnail
// We are using Userboy's first image, which is linked to "The Wonderful Painting" artwork
$c = new Criteria();
$c->add(sfGuardUserPeer::USERNAME, "userboy");
$c->add(ReaktorFilePeer::IDENTIFIER, "image");
$c->addAscendingOrderByColumn("id");
$c->addJoin(ReaktorFilePeer::USER_ID, sfGuardUserPeer::ID);
//$c->addJoin(ReaktorFilePeer::LOCATION_ID, FileLocationPeer::ID);
$fileObject  = ReaktorFilePeer::doSelectOne($c);
$thisImageFile = new artworkFile($fileObject->getId()); 
$parentImageArtwork = $thisImageFile->getParentArtwork();

//Navigate to the correct edit page
$b->get("/upload/edit/".$thisImageFile->getId());

//Lets log in as the wrong user - this user should always exist in test db
$b->setField('password', 'monkeyboy');
$b->setField('username', 'monkeyboy');
$b->click('Sign in');
$b->isRedirected()->followRedirect();

// This is not monkeyboy's work, so he gets a 404
$b->isStatusCode(404);

// Try with userboy
$b->click('Log out');
$b->get("/upload/edit/".$thisImageFile->getId());

$b->setField('password', 'userboy');
$b->setField('username', 'userboy');
$b->click('Sign in');
$b->isRedirected()->followRedirect();

$b->isStatusCode();
$b->isRequestParameter('module', 'upload');
$b->isRequestParameter('action', 'edit');

// Now we should be looking at the edit page
$b->checkResponseElement("div#editpage_form", "*Modify file details*");

// This file should be linked to User Boy's first artwork, and contain a link to it

$b->checkResponseElement('div#editpage_form', '*(Part of '.$parentImageArtwork->getTitle().' artwork)*');

// Since this is an image file, thumbnail upload should not be available
$b->checkResponseElement('div#thumbnail_editpage', '!*startCallback()*');

// Check that the page is displaying the correct data for this file
$b->responseContains($thisImageFile->getMetadata("title"));
$b->responseContains($thisImageFile->getMetadata("creator"));
$b->responseContains($thisImageFile->getMetadata("description", "abstract"));
$b->responseContains($thisImageFile->getMetadata("description", "creation"));
$b->responseContains($thisImageFile->getMetadata("relation", "references"));
$b->responseContains('<option value="'.$thisImageFile->getMetadata("license").'" selected="selected">');

// Lets do it all again with a pdf file, and see if we can edit thumbnail this time
$c = new Criteria();
$c->add(sfGuardUserPeer::USERNAME, "userboy");
$c->add(ReaktorFilePeer::IDENTIFIER, "pdf");
$c->addAscendingOrderByColumn("id");
$c->addJoin(ReaktorFilePeer::USER_ID, sfGuardUserPeer::ID);
//$c->addJoin(ReaktorFilePeer::LOCATION_ID, FileLocationPeer::ID);
$fileObject  = ReaktorFilePeer::doSelectOne($c);
$thisPdfFile = new artworkFile($fileObject->getId());
$parentPdfArtwork = $thisPdfFile->getParentArtwork(); 

//Navigate to the new edit page
$b->get("/upload/edit/".$thisPdfFile->getId());

$b->isStatusCode();
$b->isRequestParameter('module', 'upload');
$b->isRequestParameter('action', 'edit');

// Check that the page is displaying the correct data for this file
$b->responseContains($thisPdfFile->getMetadata("title"));
$b->responseContains($thisPdfFile->getMetadata("creator"));
$b->responseContains($thisPdfFile->getMetadata("description", "abstract"));
$b->responseContains($thisPdfFile->getMetadata("description", "creation"));
$b->responseContains($thisPdfFile->getMetadata("relation", "references"));
$b->responseContains('<option value="'.$thisPdfFile->getMetadata("license").'" selected="selected">');

// Since this is now a pdf file, thumbnail upload should now be available
$b->checkResponseElement('div#thumbnail_editpage', '*startCallback()*');

// ZOID: Can't check image upload for new thumb in this version

// Now lets check what option userboy has
// This is the first pdf file, which is a linked file so should only have options to save or cancel
$b->responseContains('name="save_edit"');
$b->responseContains('value="Cancel"');

//User is not admin, so should not be able to delete
$b->checkResponseElement('body', '!*Delete this file*');

//What if we log in as admin then?
$b->click('Log out');
$b->get("/upload/edit/".$thisImageFile->getId());

$b->setField('password', 'admin');
$b->setField('username', 'admin');
$b->click('Sign in');
$b->isRedirected()->followRedirect();

$b->isStatusCode();
$b->isRequestParameter('module', 'upload');
$b->isRequestParameter('action', 'edit');

//User is now admin, so should have option to delete
$b->responseContains('Delete this file');
$b->responseContains('name="save_edit"');
$b->responseContains('value="Cancel"');

// Ok, now some form validation, lets clear everything and save
$b->setField("title", "");
$b->setField("author", "");
$b->setField("description", "");
$b->setField("production", "");
$b->setField("resources", "");
$b->setField("meta_license", "");

$b->click("Save changes");

$b->checkResponseElement("div#editpage_form", "*The data was not saved!*");
$b->checkResponseElement("div#error_for_title", "*Required*");
$b->checkResponseElement("div#error_for_author", "*Required*");
$b->checkResponseElement("div#error_for_description", "*Required*");
$b->checkResponseElement("div#error_for_production", "!*Required*");
$b->checkResponseElement("div#error_for_resources", "!*Required*");
$b->checkResponseElement("div#error_for_meta_license", "*Required*");

// Now lets try with erroneus data
$b->setField("title", "a");
$b->setField("author", "a");
$b->setField("description", "a");
$b->setField("production", "a");
$b->setField("resources", "a");
$b->setField("meta_license", "a");

$b->click("Save changes");

$b->checkResponseElement("div#editpage_form", "*The data was not saved!*");
$b->checkResponseElement("div#error_for_title", "*Please enter at least 3 characters*");
$b->checkResponseElement("div#error_for_author", "*Enter at least 3 characters*");
$b->checkResponseElement("div#error_for_description", "*Enter at least 5 characters*");
$b->checkResponseElement("div#error_for_resources", "*An invalid URL has been specified*");
//ZOID: Meta license check for one from DB!
//$b->checkResponseElement("div#error_for_meta_license", "*Required*");

// Now we should test the options for an unlinked file
// Lets remove the file association for the current file and reload the page
$parentImageArtwork->removeFile($thisImageFile);

// Log back in as userboy
$b->click('Log out');
$b->get("/upload/edit/".$thisImageFile->getId());

$b->setField('password', 'userboy');
$b->setField('username', 'userboy');
$b->click('Sign in');
$b->isRedirected()->followRedirect();
$b->isStatusCode();
$b->isRequestParameter('module', 'upload');
$b->isRequestParameter('action', 'edit');

// We should now see an unlinked file page
$b->checkResponseElement("div#editpage_form", "!*Part of*");

// Check that the page is displaying the correct data for this file
$b->responseContains($thisImageFile->getMetadata("title"));
$b->responseContains($thisImageFile->getMetadata("creator"));
$b->responseContains($thisImageFile->getMetadata("description", "abstract"));
$b->responseContains($thisImageFile->getMetadata("description", "creation"));
$b->responseContains($thisImageFile->getMetadata("relation", "references"));
$b->responseContains('<option value="'.$thisImageFile->getMetadata("license").'" selected="selected">');

// We should now have completely different options at the bottom of the page
$b->checkResponseElement("div#new_file_save", "*Save and create new artwork*");
$b->checkResponseElement("div#save_file_draft", "*Save but do not submit yet*");

// We know userboy has more images, so we should have the link option
$b->checkResponseElement("div#link_file_save", "*Save and attach to previous artwork*");

// Lets check that our link list contains all the related/eligible artworks
$c = new Criteria();
$c->add(ReaktorArtworkPeer::ARTWORKTYPE, "image");
$c->add(ReaktorArtworkPeer::USER_ID, sfGuardUserPeer::retrieveByUsername("userboy")->getId());
$eligibleArtwork = ReaktorArtworkPeer::doSelect($c);

foreach ($eligibleArtwork as $artworkObject)
{
  $b->checkResponseElement("div#link_file_save", "*".$artworkObject->getTitle()."*");
}

// Check save as draft relaxed criteria
$b->setField("title", "");
$b->setField("author", "");
$b->setField("description", "");
$b->setField("production", "");
$b->setField("resources", "");
$b->setField("meta_license", "");

$b->click("Save as draft");
$b->checkResponseElement("div#editpage_form", "*The data was not saved!*");
$b->checkResponseElement("div#error_for_title", "*Required*");
$b->checkResponseElement("div#error_for_author", "!*Required*");
$b->checkResponseElement("div#error_for_description", "!*Required*");
$b->checkResponseElement("div#error_for_production", "!*Required*");
$b->checkResponseElement("div#error_for_resources", "!*Required*");
$b->checkResponseElement("div#error_for_meta_license", "!*Required*");

// Check save as draft relaxed criteria
$b->setField("title", "A title");
$b->setField("author", "");
$b->setField("description", "");
$b->setField("production", "");
$b->setField("resources", "");
$b->setField("meta_license", "");

$b->click("Save as draft");
$b->checkResponseElement("div#editpage_form", "!*The data was not saved!*");
$b->checkResponseElement("div#editpage_form", "*Save successful*");
$b->checkResponseElement("div#error_for_title", "!*Required*");
$b->checkResponseElement("div#error_for_author", "!*Required*");
$b->checkResponseElement("div#error_for_description", "!*Required*");
$b->checkResponseElement("div#error_for_production", "!*Required*");
$b->checkResponseElement("div#error_for_resources", "!*Required*");
$b->checkResponseElement("div#error_for_meta_license", "!*Required*");

// Ok lets populate and try creating a new artwork, first with collection box unchecked
$b->setField("title", "A title");
$b->setField("author", "An Author");
$b->setField("description", "Something");
$b->setField("meta_license", "contact");
$b->setField("tags", "something");

// FIXME: dae says: this needs to be updated when the subreaktor <-> artwork functionality is back
// ZOID: this needs to be updated when the subreaktor <-> artwork functionality is back
/*$b->click("Save as new artwork");
$b->isRedirected()->followRedirect();

$b->isStatusCode();
$b->isRequestParameter('module', 'artwork');
$b->isRequestParameter('action', 'show');

$b->checkResponseElement("div#content_main", "*A title*");

// That's enough to check that, lets go back to our page...
$c = new Criteria();
$c->add(sfGuardUserPeer::USERNAME, "userboy");
$c->add(ReaktorFilePeer::IDENTIFIER, "image");
$c->addAscendingOrderByColumn("id");
$c->addJoin(ReaktorFilePeer::USER_ID, sfGuardUserPeer::ID);
//$c->addJoin(ReaktorFilePeer::LOCATION_ID, FileLocationPeer::ID);
$fileObject  = ReaktorFilePeer::doSelectOne($c);
$thisImageFile = new artworkFile($fileObject->getId()); 
$parentImageArtwork = $thisImageFile->getParentArtwork();

// We need to revert first though, since we don't want this link any more
$parentImageArtwork->removeFile($thisImageFile);

$b->get("/upload/edit/".$thisImageFile->getId());
$b->isStatusCode();
$b->isRequestParameter('module', 'upload');
$b->isRequestParameter('action', 'edit');

// Fields should already be saved from previously, so lets go ahead and try tho create new artwork
// With the collection button checked...

$b->checkResponseElement("div#link_file_save", "*Save and attach to previous artwork*");
$b->setField("upload_another", "checked");
$b->click("Save as new artwork");
$b->isRedirected()->followRedirect();

$b->isStatusCode();
$b->isRequestParameter('module', 'upload');
$b->isRequestParameter('action', 'upload');

$b->checkResponseElement('div#sf_asset_container', '*'.$thisImageFile->getTitle().'*');

// Looks good, now back to the edit page
$c = new Criteria();
$c->add(sfGuardUserPeer::USERNAME, "userboy");
$c->add(FileLocationPeer::IDENTIFIER, "image");
$c->addAscendingOrderByColumn("id");
$c->addJoin(ReaktorFilePeer::USER_ID, sfGuardUserPeer::ID);
$c->addJoin(ReaktorFilePeer::LOCATION_ID, FileLocationPeer::ID);
$fileObject  = ReaktorFilePeer::doSelectOne($c);
$thisImageFile = new artworkFile($fileObject->getId()); 
$parentImageArtwork = $thisImageFile->getParentArtwork();

// We need to revert first though, since we don't want this link any more
$parentImageArtwork->removeFile($thisImageFile);

$b->get("/upload/edit/".$thisImageFile->getId());
$b->isStatusCode();
$b->isRequestParameter('module', 'upload');
$b->isRequestParameter('action', 'edit');*/

// ZOID: Add more tests, including tagging when finished