<?php
/**
 * The artwork is the most important part of reaktor, and this is where we test how
 * it is being displayed. This test covers:
 *
 * - The routing to artworks, how the URLs work when users are logged in, and when they're not
 * - The headers
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

//Get an approved artwork from the database
$c = new Criteria();
$c->add(ReaktorArtworkPeer::STATUS, 3, Criteria::EQUAL);
$approved_artwork = ReaktorArtworkPeer::doSelectOne($c);
$approved         = new genericArtwork($approved_artwork);

//Get a different approved artwork, that's not owned by previous retrieved approved artwork
$c = new Criteria();
$c->add(ReaktorArtworkPeer::STATUS, 3, Criteria::EQUAL);
$c->add(ReaktorArtworkPeer::USER_ID, $approved->getUserId(), Criteria::NOT_EQUAL);
$diff_approved_artwork = ReaktorArtworkPeer::doSelectOne($c);
$diff_approved         = new genericArtwork($diff_approved_artwork);

//Get an unapproved artwork from the database
$c = new Criteria();
$c->add(ReaktorArtworkPeer::STATUS, 2, Criteria::EQUAL);
$c->add(ReaktorArtworkPeer::USER_ID, $approved->getUserId(), Criteria::EQUAL);
$unapproved_artwork = ReaktorArtworkPeer::doSelectOne($c);
$unapproved         = new genericArtwork($unapproved_artwork);

//Get a different unapproved artwork from the database, no owned by the previous unapproved artwork
$c = new Criteria();
$c->add(ReaktorArtworkPeer::STATUS, 2, Criteria::EQUAL);
$c->add(ReaktorArtworkPeer::USER_ID, $approved->getUserId(), Criteria::NOT_EQUAL);
$diff_unapproved_artwork = ReaktorArtworkPeer::doSelectOne($c);
$diff_unapproved         = new genericArtwork($diff_unapproved_artwork);

//Get a image artwork from the database
$c = new Criteria();
$c->add(ReaktorArtworkPeer::ARTWORK_IDENTIFIER, 'image', Criteria::EQUAL);
$image_artwork = ReaktorArtworkPeer::doSelectOne($c);
$image         = new genericArtwork($image_artwork);

//Get a pdf artwork from the database
$c = new Criteria();
$c->add(ReaktorArtworkPeer::ARTWORK_IDENTIFIER, 'pdf', Criteria::EQUAL);
$pdf_artwork = ReaktorArtworkPeer::doSelectOne($c);
$pdf         = new genericArtwork($pdf_artwork);

//Get a video artwork from the database
$c = new Criteria();
$c->add(ReaktorArtworkPeer::ARTWORK_IDENTIFIER, 'video', Criteria::EQUAL);
$video_artwork = ReaktorArtworkPeer::doSelectOne($c);
$video         = new genericArtwork($video_artwork);

//Get a text artwork from the database
$c = new Criteria();
$c->add(ReaktorArtworkPeer::ARTWORK_IDENTIFIER, 'text', Criteria::EQUAL);
$text_artwork = ReaktorArtworkPeer::doSelectOne($c);
$text         = new genericArtwork($text_artwork);

//Get a audio artwork from the database
$c = new Criteria();
$c->add(ReaktorArtworkPeer::ARTWORK_IDENTIFIER, 'audio', Criteria::EQUAL);
$audio_artwork = ReaktorArtworkPeer::doSelectOne($c);
$audio         = new genericArtwork($audio_artwork);

if(!$approved)
{
  echo "Nothing to test! Following tests will fail. Check fixtures for at least one approved artwork";
}
if(!$unapproved)
{
  echo "Nothing to test! Following tests will fail. Check fixtures for at least one unapproved artwork";
}

// Show the approved artwork based on just id should fail
$b->get('/en/artwork/show/id/'.$approved->getId());
$b->isStatusCode(404);

/********** FIXME: Disabled as passing only the ID has to work for now **********/
// Showing the approved artwork using just the file id should also fail
/*
$b->get('/en/artwork/show/'.$approved->getId())
  ->isStatusCode(404);
*/

// Trying to access unapproved content when not logged in should fail, trying with and without the file id set
$b->get($unapproved->getLink('show', $unapproved->getFirstFile()->getId(), true)) 
  ->isStatusCode(404)
  ->get($unapproved->getLink('show', null, true))
  ->isStatusCode(404);
  
// Trying to access the content with just title and file should fail
$b->get('/en/artwork/show/title/'.$approved->getTitle().'/file/'.$approved->getFirstFile()->getId())
  ->isStatusCode(404);
  
// Trying to access the content with specific file id should work even if not logged in
$b->get($approved->getLink('show', $approved->getFirstFile()->getId(), true))
  ->isStatusCode(200);
echo $approved->getLink('show', $approved->getFirstFile()->getId(), true);
// Check that it displays the artwork when not logged in, and that the username is displayed and not the name
$b->get($approved->getLink('show', null, true))
  ->isStatusCode(200)
  ->checkResponseElement('div#artwork_info_header h2', '/'.$approved->getTitle().'/')
  ->checkResponseElement('div#artwork_description h4', '/Artwork description/')
  ->checkResponseElement('div#artwork_tags h4', '/Tags/')
  ->checkResponseElement('div#artwork_copyright h4', '/Copyright/')
  ->checkResponseElement('div#artwork_info_header', '/'.$approved->getUser()->getUsername().'/')
  ->checkResponseElement('div#embed_links a', '/Embed this artwork/')
  ->checkResponseElement('div#socialBookmarks h3', '/Share this artwork/');

// Log in as owner of approved artwork and check that the page content is still valid 
$b->setField('username', $approved->getUser()->getUsername())
  ->setField('password', $approved->getUser()->getUsername())
  ->click('Sign in')
  ->isRedirected()
  ->followRedirect()
  ->isStatusCode(200)
  ->checkResponseElement("div#user_summary .nickname", $approved->getUser()->getUsername())
  ->checkResponseElement('div#artwork_info_header h2', '/'.$approved->getTitle().'/')
  ->checkResponseElement('div#artwork_description h4', '/Artwork description/')
  ->checkResponseElement('div#artwork_tags h4', '/Tags/')
  ->checkResponseElement('div#artwork_copyright h4', '/Copyright/')
  ->checkResponseElement('div#artwork_info_header', '/'.$approved->getUser()->getUsername().'/');

// Trying to show the artwork based on just id should fail
$b->get('/en/artwork/show/id/'.$approved->getId())
  ->isStatusCode(404);

// Trying to just show a file should fail
$b->get('/en/artwork/show/file/'.$approved->getFirstFile()->getId())
  ->isStatusCode(404);

// Trying to access an artwork with a wrong title should not fail if you are the owner
$b->get('/en/artwork/show/title/'.str_shuffle($approved->getTitle()).'/id/'.$approved->getId())
  ->isStatusCode(200);
//Check out artwork by another user
$name = $diff_approved->getUser()->getNamePrivate() ?  $diff_approved->getUser()->getUsername() :  $diff_approved->getUser()->getUsername();
$b->get($diff_approved->getLink('show', null, true))//'/en/artwork/show/9/Nice cartoon')
  ->checkResponseElement('div#artwork_info_header', '/'.$name.'/');

// Trying to access artwork with a wrong title should fail if you are not the owner
$b->get('/en/artwork/show/title/'.str_shuffle($diff_approved->getTitle()).'/id/'.$diff_approved->getId())
// FIXME: For the moment this should work. However, this behaviour will be 
// reverted after the test-release
// ->isStatusCode(404);
  ->isStatusCode(200);

// Trying to access an artwork with a wrong title should fail if you are not the owner, also when file i specified
$b->get('/en/artwork/show/title/'.str_shuffle($diff_approved->getTitle()).'/id/'.$diff_approved->getId().
        '/file/'.$diff_approved->getFirstFile()->getId())
//'title/'wrong title/id/9/file/11')
  //->isStatusCode(404);
  ->isStatusCode(200); // FIXME: See FIXME above

// Trying to access the content with just title and file should fail also if you are not the owner
$b->get('/en/artwork/show/title/'.$diff_approved->getTitle().'/file/'.$diff_approved->getFirstFile()->getId())
        //'/en/artwork/show/title/My Pdf/file/2')
  ->isStatusCode(404);

// Trying to access the content with specific file id as well should not fail when logged in
$b->get($diff_approved->getLink('show', $diff_approved->getFirstFile()->getId(), true))
//'/en/artwork/show/3/2/My Pdf')
  ->isStatusCode(200);

// Check that we can access unapproved artwork when logged in as owner of it, with and without file set
$b->get($unapproved->getLink('show', $unapproved->getFirstFile()->getId(), true)) 
  ->isStatusCode(200)
  ->get($unapproved->getLink('show', null, true))
  ->isStatusCode(200);
  
// Check that we can't access unapproved artwork when logged in as normal users, and we aren't the owner with and without file set
$b->get($diff_unapproved->getLink('show', $diff_unapproved->getFirstFile()->getId(), true)) 
  ->isStatusCode(404)
  ->get($diff_unapproved->getLink('show', null, true))
  ->isStatusCode(404);
  
// Log out
$b->click('Log out');

// Log in as admin
$b->get('/en')
  ->setField('username', 'admin')
  ->setField('password','admin')
  ->click('Sign in')
  ->isRedirected()
  ->followRedirect();

// Check that we are logged in
$b->checkResponseElement('div#user_summary .nickname', 'admin');

// Check that we can access unapproved artwork when logged in as admin, both with and without file set
$b->get($unapproved->getLink('show', $unapproved->getFirstFile()->getId(), true)) 
  ->isStatusCode(200)
  ->get($unapproved->getLink('show', null, true))
  ->isStatusCode(200);


// Check multi file image artwork, it is exactly the same, except it has a link to view a slideshow
$b->get('/en/artwork/show/2/The fancy gallery')
  ->isStatusCode(200)
  ->checkResponseElement('div#magnify_div a', '/View slideshow/');
  

$format_artworks = array ($image, $pdf, $video, $text, $audio);

//Finally we check that each of the different formats have roughly the same content
foreach($format_artworks as $format_artwork)
{
  $b->get($format_artwork->getLink('show', null, true))
  ->isStatusCode(200)
  ->checkResponseElement('div#artwork_info_header h2', '/'.$format_artwork->getTitle().'/')
  ->checkResponseElement('div#artwork_tags h4', '/Tags/')
  ->checkResponseElement('div#artwork_copyright h4', '/Copyright/')
  ->checkResponseElement('div#artwork_info_header', '/by '.$format_artwork->getUser()->getUsername().'/')
  ->checkResponseElement('div#embed_links a', '/Embed this artwork/')
  ->checkResponseElement('div#socialBookmarks h3', '/Share this artwork/')
  ->checkResponseElement('div.artwork_tag_block ul', true)
  ->checkResponseElement('div#artwork_actions_and_favourites', true)
  ->checkResponseElement('div#artwork_rating ul', true)
  ->checkResponseElement('div#commentlist', true)
  ->checkResponseElement('div#artwork_time_and_report', true)
  ->checkResponseElement('div.moderator_block h2', 'Moderator');
if ($format_artwork->getArtworkType() != 'text')
{
  $b->checkResponseElement('div#artwork_description h4', '/Artwork description/');
}

}

//->checkResponseElement('div#artwork_div','/FlowPlayerLight.swf/' );// '/VM_EmbedFlash/');
//->responseContains('/FlowPlayerLight.swf/');//'VM_EmbedFlash');
//->responseContains('application/x-shockwave-flash');
//->checkResponseElement("div#content_main script[type='text/javascript']", '/xspf_player/');
  

?>
