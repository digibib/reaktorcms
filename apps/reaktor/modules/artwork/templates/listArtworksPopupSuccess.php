<?php
decorate_with(false);
use_helper("Javascript");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Browse artworks</title>
    <script type="text/javascript" src="/js/tiny_mce/tiny_mce_popup.js?v=307"></script>
    <script type="text/javascript" src="/js/tiny_mce/plugins/artworklist/js/dialog.js?v=307"></script>
    <script type="text/javascript" src="/sf/sf_web_debug/js/main.js"></script>
    <script type="text/javascript" src="/js/prototype.js"></script>

    <script type="text/javascript" src="/js/scriptaculous.js"></script>
    <script type="text/javascript" src="/js/main.js"></script>
    <script type="text/javascript" src="/js/dw_cookies.js"></script>
    <script type="text/javascript" src="/js/dw_sizerdx.js"></script>
    <script type="text/javascript" src="/js/VM_FlashContent.js"></script>
    <link rel="stylesheet" type="text/css" media="all" href="/css/main.css" />

</head>
<body style="margin: 30px;">
<?php echo form_tag('@browsearticleartworks?article_id='. $article->getId(), array(
                        'id'    => 'listartform', 
                        'name'  => 'listartform'));?>
  <?php include_partial('artwork/listArtworksPopupChoices', array('artworks' => $artworks, 'article' => $article)); ?>

  <?php echo input_auto_complete_tag('filter', '', '@browsearticleartworks?article_id='. $article->getId(), null, array('frequency' => 0.2,))?>
  <?php echo submit_to_remote('artlist_ajax_submit', __('Filter by tag'),
                             array('update'   => array('success' => 'artworkslist', 'failure' => 'artworkslist'),
                                   'url'      => '@browsearticleartworks?article_id='. $article->getId(),
                                   'script'   => true),
                             array('class' => 'submit'))?>
  <input type="submit" value="<?php echo __("Cancel")?>" onclick="tinyMCEPopup.close();" />
</form>

</body>
</html>


