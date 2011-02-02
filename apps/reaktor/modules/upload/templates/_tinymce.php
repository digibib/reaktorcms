<?php
/**
 * TinyMCE plugin for creating a text artwork online
 * This template is included on the upload/edit page when creating or editing a text artwork - all TinyMCE options
 * for this process are configured here in the javascript block below.
 * 
 * - $mce_data : The contents of the text field, if set it will be prefilled - if not an empty textarea will be loaded
 * 
 * PHP Version 5
 *
 * @author    Ole-Peter Wikene <olepw@linpro.no>
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

?>

<!-- TinyMCE -->
<script type="text/javascript" src="/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
  tinyMCE.init({
      mode : "exact",
      language: "<?php $tynylang=strtolower(substr(sfContext::getInstance()->getUser()->getCulture(), 0, 2)); print($tynylang=='no'? 'nb' : $tynylang); ?>",
      elements : "mce_data",
      theme : "advanced",
      theme_advanced_buttons1 : "link,bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo",
      theme_advanced_buttons2 : "",
      theme_advanced_buttons3 : "",
      theme_advanced_toolbar_location : "top",
      theme_advanced_toolbar_align : "left",
      theme_advanced_statusbar_location : "bottom",
      theme_advanced_resizing : true,
      paste_use_dialog : true,
      paste_auto_cleanup_on_paste : true,
      
      plugins : 'paste,inlinepopups'
  });
</script>
<?php if (isset($mce_data)): ?>
  <?php echo textarea_tag('mce_data', $mce_data , array("size" => "80x52")) ?>
<?php else: ?>
  <?php echo textarea_tag('mce_data', '', array("size" => "80x52")) ?>
<?php endif ?>

