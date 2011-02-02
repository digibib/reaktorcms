<?php
/**
 * Functional test for translation interface
 * 
 * PHP Version 5
 *
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

include(dirname(__FILE__).'/../../bootstrap/functional.php');

//$crit = new Criteria();
$trans_en = new TransUnit();
$trans_en->setSource('LokalReaktor');
$trans_en->setTranslated(true);
$trans_en->setTarget('English lokalreaktor');
$trans_en->setId(15);
$trans_en->setDateAdded(time());
$trans_en->setCatId(3);
$trans_en->save();

$trans_no = new TransUnit();
$trans_no->setSource('LokalReaktor');
$trans_no->setTranslated(true);
$trans_no->setTarget('Bokmål lokalreaktor');
$trans_no->setId(15);
$trans_no->setDateAdded(time());
$trans_no->setCatId(1);
$trans_no->save();

$trans_nn = new TransUnit();
$trans_nn->setSource('LokalReaktor');
$trans_nn->setTranslated(true);
$trans_nn->setTarget('Nynorsk lokalreaktor');
$trans_nn->setId(15);
$trans_nn->setDateAdded(time());
$trans_nn->setCatId(2);
$trans_nn->save();

// create a new test browser
$b = new reaktorTestBrowser();
$b->initialize();

// Only admin/transadmin can get translation list
$b->get('/en/admin/translation/list')
  ->isStatusCode(200)
  ->checkResponseElement('h1', '!*Translation list*')
;

// Log in as a translator
$b->setField('password', 'languageboy')
  ->setField('username', 'languageboy')
  ->click('Sign in')
  ->isStatusCode(302)
  ->isRedirected()->followRedirect()
  ->checkResponseElement('h1', '*Translation list*')
;


// Search for a specific "source string"
// filters[source]=LokalReaktor&filters[translated]=&filters[cat_id]=3&filter=filter
$b->call('/en/admin/translation/list', 'get', array(
  "filters" => array(
    "source" => "Lokalreaktor",
    "translated" => "",
    "cat_id" => 3, // English
  ),
  "filter" => "filter"
));

$b->responseContains("1 result")
  ->checkResponseElement("tr.sf_admin_row_0 td", "/en/")
  ->checkResponseElement("tr.sf_admin_row_0 td a", "/LokalReaktor/")
;

// Edit The "Lokalreaktor" string
$b->get('en/sfTransUnit/edit/msg_id/1')
  ->isStatusCode(200)
  ->checkResponseElement('h1', '*Edit Translation*')
  ->responseContains('English lokalreaktor')
  ->responseContains('Bokmål lokalreaktor')
  ->responseContains('Nynorsk lokalreaktor')
;

// Translate to english
$b->setField("trans_unit_1[target]", "Bokmål lokalgåseby")
  ->setField("rans_unit_1[translated]", "1")
  ->setField("trans_unit_2[target]", "Nynorsk lokalgåseby")
  ->setField("rans_unit_2[translated]", "1")
  ->setField("trans_unit_3[target]", "English lokalgåseby")
  ->setField("rans_unit_3[translated]", "1")
  ->click("save")
  ->isRedirected()
  ->followRedirect()
  ->isStatusCode(200)
  ->checkResponseElement("h2", "/Your modifications have been saved/")
;