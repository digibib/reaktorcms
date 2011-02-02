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
</head>

<?php //The bodym html and wrapper tags and the html are closed in _footer.php ?>
<body onload="dw_fontSizerDX.init()">

<?php // tooltip must be included in the body, and not the head as it relies on the dom objects to be loaded ?>
<script type="text/javascript" src="/js/wz_tooltip.js"></script>

<div>
<?php // wrapper div is closed in the footer, as it surrounds all page content and keeps the site centred ?>