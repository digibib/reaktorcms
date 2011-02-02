<?php
/**
 * Footer template just to keep the main layout template a bit cleaner
 * 
 * This file should include anything that will appear on the bottom of
 * each page, such as copyright notices and links to privacy policy, faq
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
?>

<div id="footer_block">
  <div id="footer_menu">
	  <?php include_partial('global/bottom_menu'); ?>
  </div>
  <div id="footer_images">
		<?php echo link_to(image_tag('logoDeichman.gif', array('alt' => 'Deichmanske bibliotek', 'title' => 'Deichmanske bibliotek')), 'http://www.deichman.no') ?>
		<?php echo link_to(image_tag('logoTrheim.gif', array('alt' => 'Trondheim folkebibliotek', 'title' => 'Trondheim folkebibliotek')), 'http://www.tfb.no') ?>
		<?php # echo link_to(image_tag('logoNDB.gif', array('alt' => 'Norsk digitalt bibliotek', 'title' => 'Norsk digitalt bibliotek')), 'http://www.norskdigitaltbibliotek.no') ?>
		<?php echo link_to(image_tag('logoKN.gif', array('alt' => 'Kulturnett.no', 'title' => 'Kulturnett.no')), 'http://www.kulturnett.no') ?>
    <p class="small_text faded_text">
      Ansvarlig redaktør: Deichmanske bibliotek. Kontakt redaksjonen: <?php echo mail_to('reaktor@deichman.no'); ?>. 
      Reaktor konsept og id&eacute; &copy; 2003 Deichmanske bibliotek
    </p>
	</div>
</div>

<?php // The following tags are opened in the header partials, the div is "wrapper" and surrounds all content ?>
</div>

<?php // Any javascript that needs to be run after the page is rendered follows
  $footerJs = $sf_request->getAttribute('footer_js', array());
  if (!empty($footerJs))
  {
    echo javascript_tag(implode("\n", $footerJs));
  }
?>

</body>
</html>