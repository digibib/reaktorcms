<?php
/**
 * The Reaktor site provides the readers with useful information from its editorial staff through articles. 
 * This template displays the form for editing such articles, it's an article content editor (title, ingress, 
 * content) partial. Used on the artwork edit page, can be included on custom
 * article edit pages. To use:
 * 
 *  include_partial('editarticlecontents', array(
 *   'article' => $article, 
 *   'buttons' => $show_attachments_edit));
 * 
 * $article : Article Object - The article to be edited
 * $buttons : boolean - If true, display the attach artwork to this article button in tinymce 
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @author    Hannes Magnusson <bjori@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1 
 * @param Article $article The article to be edited
 * @param boolean $buttons If true, display the attach artwork to this article button in tinymce
 */

$article_types                       = ArticlePeer::getArticleTypesByPermission($sf_user);
$article_types                       = array(0 => ' -- ' . sfContext::getInstance()->getI18N()->__('Please select an article type') . ' -- ') + $article_types;
$statuses = array(
  ArticlePeer::DRAFT     => __("Draft"),
  ArticlePeer::PUBLISHED => __("Publish"),
  ArticlePeer::ARCHIVED  => __("Archive"),
  //ArticlePeer::DELETED   => __("Delete"),
);

$buttons_line = array();
if($buttons)
{
  $buttons_line += array("artworklist", "upload");
}
if($article->getArticletype() == ArticlePeer::THEME_ARTICLE)
{
  $buttons_line[] = 'insertbanner';
}

use_helper('wai');
?>

<script type="text/javascript" src="/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
//<![CDATA[
tinyMCE.init({
    mode : "exact",
    language: "<?php $tynylang=strtolower(substr(sfContext::getInstance()->getUser()->getCulture(), 0, 2)); print($tynylang=='no'? 'nb' : $tynylang); ?>",
    elements : "article_content",
    theme : "advanced",
    theme_advanced_buttons1 : "media,bold,italic,underline,strikethrough,|,bullist,numlist,|,justifyleft,justifycenter,justifyright,justifyfull,|,undo,redo,|,image,code,anchor,link, <?php echo join(",", $buttons_line); ?>",
    theme_advanced_buttons2 : "",
    relative_urls : false, 
    theme_advanced_buttons3 : "",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
    theme_advanced_resizing : true,
    paste_use_dialog : true,
    paste_auto_cleanup_on_paste : true,
    plugins : "media,paste,inlinepopups,xhtmlxtras<?php if ($buttons_line) echo ", "; echo join(", ", $buttons_line); ?>"
});
function insertBannerMarkup() {
  if (typeof($('banner_form').banner) == 'undefined') {
    alert("<?php echo __("You must upload and select a banner before you can place it in the article..")?>");
    return;
  }
  if (typeof($('banner_form').banner.length) == 'undefined') {
    injectMarkup($('banner_form').banner.value);
    return;
  }
  for (var i=0; i < $('banner_form').banner.length; i++) {
    if ($('banner_form').banner[i].checked) {
      injectMarkup($('banner_form').banner[i].value);
    }
  }
}

function getfileextension(filename) 
{ 
 
    if( filename.length == 0 ) return ""; 
    var dot = filename.lastIndexOf("."); 
    if( dot == -1 ) return ""; 
    var extension = filename.substr(dot,filename.length); 

 return extension.toUpperCase(); 
} 



function injectMarkup(idArg) {
      new Ajax.Request('/resolveUploadFileId', {
        method: 'post',
        onSuccess: function(transport) {
          var json = eval(transport.headerJSON);

        if(getfileextension(json['absolutePath'])==".SWF"){
var str = ' <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="100" height="100" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0">'+
        '<param name="src" width="'+json['width']+'" height="'+json['height']+'" value="' +json['absolutePath']+ '<?php echo '?clickTAG='.urlencode(url_for($article->getLink())); ?>'+
        '<embed type="application/x-shockwave-flash" src="' +json['absolutePath']+ '<?php echo '?clickTAG='.urlencode(url_for($article->getLink())); ?>"></embed>'+
        '</object>';



            } else {
          var str = '<img src="' +json['absolutePath']+ '" height="' +json['height']+ '" width="' +json['width']+ '" align="left" alt=""/>';
            }
          tinyMCE.execCommand('mceInsertRawHTML', false, str);
        },
        parameters: {id: idArg}
      });

}
function checkBanner() {
  if (typeof($("banner_form").banner.length) == 'undefined' && $("banner_form").banner.checked == 0) {
    $("banner_form").banner.checked = 1;
    setBanner();
  }
}
function setBanner() {
  new Ajax.Updater(
    'article_attachments_container',
    '<?php echo url_for("@article_set_banner?article_id=" . $article->getId())?>', 
    {
      asynchronous:true, evalScripts:false,
      onSuccess:function(request, json){}, 
      parameters: $('banner_form').serialize()
    }
  ); 
//  insertBannerMarkup();
  return false;
}
function updateArticles() {
  new Ajax.Updater('article_attachments_container', '<?php echo url_for('@showarticle_attachments?article_id=' .$article->getId())?>', 
                    {asynchronous:true, evalScripts:true, onComplete:function(request, json){checkBanner()}});
}
function updateArtworks() {
  new Ajax.Updater('article_artworks_container', '<?php echo url_for('@showarticle_artworks?article_id=' .$article->getId())?>', 
                    {asynchronous:true, evalScripts:true});
}
function injectArtwork(idArg) {
  new Ajax.Request('/resolveArtworkId', {
    method: 'post',
    onSuccess: function(transport) {
      responseArray = eval(transport.headerJSON);
      tinyMCE.execCommand('mceInsertRawHTML', false, responseArray[0]);
    },
    parameters: {id: idArg}
  });
}
//]]>
</script>

<div id = "editarticlecontents">
  <?php if (!$article->getId()): ?>
    <?php echo form_tag('@createarticle'); ?>
  <?php else: ?>
    <?php echo form_tag('@editarticle?article_id='.$article->getId()); ?>
    <?php echo input_hidden_tag('popup_id', $article->getId()) ?>
  <?php endif; ?>
    <div style="float: right;">
  	  <?php echo form_error('article_type'); ?>
  	  <?php echo select_tag('article_type', options_for_select($article_types, $article->getArticletype())); ?>
    </div>
  	<?php if (!$article->getId()): ?>
  	  <h2><?php echo __('Create new article'); ?></h2>
  	<?php else: ?>
  	  <h2><?php echo __('Editing article: %article_title%', array("%article_title%" => "<br />".reaktor_link_to($article->getTitle(), "@article?permalink=".$article->getPermalink()))); ?></h2>
  	  <?php include_component('articles', 'listCreators', array("article" => $article)); ?>
  	<?php endif; ?>
    <br class="clearboth" />
  	<?php echo form_error('article_title'); ?>
  	<?php if ($article->hasTranslatableTitle()): ?>
    	<span style="font-weight: bold;"><?php echo __("Title"); ?></span><br />
  	  <?php foreach(CataloguePeer::getCatalogues(true) as $lang => $langName): ?>
    		<?php echo wai_label_for("article_title_i18n_".$lang, $langName.":", array("class" => "language_label")); ?>
    		<?php echo input_tag('article_title_i18n['.$lang.']', $article->getTitle($lang)); ?>
    		<br />	
    	<?php endforeach; ?>
    <?php else: ?>
    	<?php echo wai_label_for("article_title", __('Title')); ?>
      <?php echo input_tag('article_title', ($sf_request->getParameter('article_title') ? $sf_request->getParameter('article_title') : $article->getBaseTitle())); ?>
    <?php endif; ?>
    <?php if ($article->getPermalink()): ?>
      <div style =" text-align:right;margin-right:<?php echo $article->hasTranslatableTitle() ? "70px" : "172px" ?>;">
        <?php echo wai_label_for("reset_permalink", __("Reset permalink: "), array("style" => "display:inline;")); ?>
        <?php echo checkbox_tag("reset_permalink"); ?>
      </div>
    <?php endif; ?>
    <?php echo wai_label_for('article_ingress', __('Ingress')); ?>
    <?php echo form_error('article_ingress'); ?>

<script type="text/javascript">
//<![CDATA[
tinyMCE.init({
    mode : "exact",
    language: "<?php $tynylang=strtolower(substr(sfContext::getInstance()->getUser()->getCulture(), 0, 2)); print($tynylang=='no'? 'nb' : $tynylang); ?>",
    elements : "article_ingress",
    theme : "advanced",
    theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,bullist,numlist,|,justifyleft,justifycenter,justifyright,justifyfull,undo,redo,|,image,code,anchor,link",
    theme_advanced_buttons2 : "",
    theme_advanced_buttons3 : "",
    relative_urls : false, 
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
    theme_advanced_resizing : true,
    paste_use_dialog : true,
    paste_auto_cleanup_on_paste : true,
    plugins : "paste,inlinepopups,xhtmlxtras<?php if ($buttons_line) echo ", "; echo join(", ", $buttons_line); ?>"
});
//]]>
</script>
    <?php echo textarea_tag('article_ingress', ($sf_request->getParameter('article_ingress') ? $sf_request->getParameter('article_ingress') : $article->getIngress()), array('size' => '80x32', 'class' => 'article_edit_area')); ?>


    <?php /*  echo input_tag('article_ingress', ($sf_request->getParameter('article_ingress') ? $sf_request->getParameter('article_ingress') : $article->getIngress())); */?>
    <?php echo wai_label_for("article_content", __('Content')); ?>
    <?php echo form_error('article_content'); ?>
    <?php echo textarea_tag('article_content', ($sf_request->getParameter('article_content') ? $sf_request->getParameter('article_content') : $article->getContent()), array('size' => '80x52', 'class' => 'article_edit_area')); ?>

    <div id="article_<?php echo $article->getId(); ?>_save_buttons" class="artwork_save_buttons">
      <?php if ($article->getId()): ?>
        <ul>
        
          <li>
            <?php //echo checkbox_tag('sticky', 1, $article->getIsSticky()); ?>
            <?php //echo wai_label_for("sticky", __('Make article sticky'), array("style" => "display:inline;")); ?>
          </li>
        
          <?php if ($article->getArticleType() == ArticlePeer::THEME_ARTICLE || $article->getArticleType() == ArticlePeer::REGULAR_ARTICLE): //Only display frontpage option for theme and regular articles?>
          
            <li>


              <?php echo checkbox_tag('frontpage', 1, $article->getFrontpage() & ArticlePeer::REAKTOR_FRONTPAGE ); ?>
              <?php echo wai_label_for("frontpage", __('Display on Reaktor front page'), array("style" => "display:inline;")); ?>
            </li>
            <li>
            
              <?php echo checkbox_tag('subfrontpage', 1, $article->getFrontpage() & ArticlePeer::SUBREAKTOR_FRONTPAGE); ?>
              <?php echo wai_label_for("subfrontpage", __('Display on SubReaktor front page'), array("style" => "display:inline;")); ?>
            </li>
            
          <?php endif ?>
          
        </ul>      
      <?php endif; ?>

      <p class = "position_right margin_for_mcebox">
        <?php if ($article->getId() == 0): ?>
    	    <?php echo __("The article type must be saved before continuing: "), submit_tag(__('Save and continue')); ?>
        <?php else: ?>
          <?php echo select_tag('status', options_for_select($statuses, $article->getArticleStatus()), array('onChange' => 'javascript:this.form.submit();')); ?>
          <?php echo submit_tag(__('Save changes')) ?>
        <?php endif; ?>
      </p>
    </div>

  <?php echo '</form>'; ?>
</div>

