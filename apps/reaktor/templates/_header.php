<?php
/**
 * Main page header partial
 * 
 * This template is the first to be rendered, so it's output always appear at the very beginning of the generated
 * html file. The first line after the closing php tag ( ?> ) should be the doctype declaration. Technically layout.php
 * is rendered before this one, but this file should be the first one that layout.php includes.
 * 
 * Header file mainly contains the content of the head tags and any opening
 * Tags such as body, html and the wrapper div which are all closed in _footer.php
 *
 * Also in the header template is anything that should appear at the top of every page, such as the font resizer
 * and language links.
 * 
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

use_helper("Javascript");
$supported_browser = false;
//var_dump(browser_detection('moz_version'));
switch (browser_detection('browser'))
{
	case 'op':
		if (browser_detection('math_number') >= 9) $supported_browser = true;
		break;
	case 'moz':
		$moz_info = browser_detection('moz_version');
		if ($moz_info[1] >= 2) $supported_browser = true;
		break;
	case 'ie':
		if (browser_detection('math_number') >= 7) $supported_browser = true;
		break;
  case 'saf':
    if (browser_detection('math_number') >= 3) $supported_browser = true;
    break;
}

// Page output for the entire site begins after this tag
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  
  <?php include_http_metas(); ?>
  <?php include_metas(); ?>
  <?php include_title(); ?>
 
  <link rel="shortcut icon" href="/reakfavicon.ico" />
  
  <?php 
  $rss_headers = $sf_request->getAttribute('rss_head_meta', array());

  foreach ($rss_headers as $rss_header)
  {
    echo auto_discovery_link_tag('rss', $rss_header['url'], array('title' => $rss_header['title']));
  }

  ?>
  
  <script type="text/javascript">
  //<![CDATA[
 
  function fontResizerLoad(flag) {
  
    try {
      dw_fontSizerDX.init();
    } catch(error){
	   if (flag == undefined) {
	     setTimeout('fontResizerLoad(1)', 2000)
	   }
  }
 }
 
 
//]]>
  
  </script>
</head>

<?php //The bodym html and wrapper tags and the html are closed in _footer.php ?>
<body onload="fontResizerLoad();">

<?php // tooltip must be included in the body, and not the head as it relies on the dom objects to be loaded ?>
<script type="text/javascript" src="/js/wz_tooltip.js"></script>

<div id = "wrapper">
  <?php if (!$supported_browser): ?>
<div id="unsupportedbrowserbanner"><b><?php echo __('Unfortunately, your browser does not work very well with Reaktor.%break%For the best experience possible, please use an up-to-date browser, such as %firefox%, %opera% or %safari%', array( '%break%' => "</b><br />\n", '%firefox%' => '<a href="http://www.getfirefox.com">Firefox</a>', '%opera%' => '<a href="http://www.opera.com">Opera</a>', '%safari%' => '<a href="http://www.apple.com/safari">Safari</a>'))?>.
	</div>
  <?php endif; ?>
  <div id = "header_block">
    <?php include_partial("global/logo"); ?>
  
    <div id = "font_selector_block">
      <?php echo link_to_function("", "dw_fontSizerDX.reset();", array("title" => __("Use normal font size"), "id" => "font_size_normal")); ?>
      <?php echo link_to_function("", "dw_fontSizerDX.reset();dw_fontSizerDX.adjust(2);", array("title" => __("Use larger font size"), "id" => "font_size_larger")); ?>
      <?php echo link_to_function("", "dw_fontSizerDX.reset();dw_fontSizerDX.adjust(4);", array("title" => __("Use largest font size"), "id" => "font_size_largest")); ?>
    </div>
  
    <div id="lang_bar">
        <?php include_component('sfTransUnit', 'langLinks', array("culture_for_cache" => $sf_user->getCulture())); ?>
    </div>
  </div>
  <?php if (!sfConfig::get("admin_mode")): ?>
    <?php include_partial('global/menubar', array("culture_for_cache" => $sf_user->getCulture(), "current_for_cache" => Subreaktor::getProvidedSubreaktorReference().Subreaktor::getProvidedLokalReference())); ?>
  <?php else: ?>
    <?php include_partial('global/adminmenubar'); ?>
  <?php endif; ?>
<?php // wrapper div is closed in the footer, as it surrounds all page content and keeps the site centred ?>
