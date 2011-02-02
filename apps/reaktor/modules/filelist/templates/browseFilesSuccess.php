<?php decorate_with(false) ?>
<?php use_helper("Javascript") ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Browse/upload attachments</title>
    <script type="text/javascript" src="/js/tiny_mce/tiny_mce_popup.js?v=307"></script>
    <script type="text/javascript" src="/sf/sf_web_debug/js/main.js"></script>
    <script type="text/javascript" src="/js/prototype.js"></script>

    <script type="text/javascript" src="/js/scriptaculous.js"></script>
    <script type="text/javascript" src="/js/inlineupload.js"></script>
    <script type="text/javascript" src="/js/main.js"></script>
    <script type="text/javascript" src="/js/dw_cookies.js"></script>
    <script type="text/javascript" src="/js/dw_sizerdx.js"></script>
    <script type="text/javascript" src="/js/VM_FlashContent.js"></script>
    <link rel="stylesheet" type="text/css" media="all" href="/css/main.css" />
</head>
<body style="margin: 30px;">
<script type="text/javascript">
var UploadDialog = { 
  close : function() {
      tinyMCEPopup.getWin().updateArticles();
      setTimeout('tinyMCEPopup.close()', 2000);

  },
  startcb : function() {
    document.getElementById('image_block').innerHTML = '<?php echo image_tag("spinning50x50.gif", array("id" => "upload_loading_room"))?>'; 
    return true;
  },
  completecb : function(response) {
    $('file').value = '';
    if (response == 'OK') {
      $('image_block').innerHTML = '<?php echo __("File uploaded and attached successfully"); ?>';
//	if(<?php echo ( $article->getArticletype()==2  ? 'true' : 'false') ?>)
//      UploadDialog.close();
//tinyMCE.execCommand(\'mceInsertBanner\', false);
    } else {
      $('errormsg').innerHTML = response;
      $('image_block').innerHTML = '';
    }
  }
};

function getfileextension(filename)
{

    if( filename.length == 0 ) return "";
    var dot = filename.lastIndexOf(".");
    if( dot == -1 ) return "";
    var extension = filename.substr(dot,filename.length);

 return extension.toUpperCase();
}



function injectMarkup(file) {
        if(getfileextension(file)==".SWF"){

var str = ' <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="100" height="100" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0">'+
	'<param name="src" value="' +file+'" />'+
	'<embed type="application/x-shockwave-flash" src="' +file+'"></embed>'+
	'</object>';


            } else {
          var str = '<img src="' +file+ '" align="left" alt=""/>';
           } 
return str;
}

</script>
<h1><?php echo __("Attach files"); ?></h1>
<?php if ($files): ?>
  <br />
  <h2><?php echo __("Attach an existing file"); ?></h2>
  <ul>

  <?php foreach($files as $id => $file): ?>
    <?php 
//	if($article->getArticletype()==2){
		$attach = "[".link_to_remote(__("Attach"), array("url" => "@article_attach?article_id=" .$article->getId(). "&file_id=" . $id, "complete" => "UploadDialog.close()"))."]";
//	}else {
//	$attach= "";
//	}
?>
    <?php $insert = '<a href="#" onClick="tinyMCE.execCommand(\'mceInsertRawHTML\', false, injectMarkup(\''.$file->getDirectLink().'\'));UploadDialog.close()">'.__("Insert into the article").'</a>';  ?>
    <li><div class = "float_left"><?php echo $file ?></div> <div style ="margin-left: 300px;"><?php echo $attach?>[<?php echo $insert?>]</div></li>
  <?php endforeach ?>
  </ul>
<?php endif; ?>

<br />
<span class="errormsg" id="errormsg"></span>
<h2><?php echo __("Uplaod a file to attach"); ?></h2>
<?php echo form_tag("@upload_attachment?article_id=" . $article->getId(), array(
  "multipart" => "true",
  "name"      => "image_upload_form",
#  "onsubmit"  => "return AIM.submit(this, {'onStart' : UploadDialog.startcb, 'onComplete' : UploadDialog.completecb })"
)
); ?>

  <div class="upload_dialog">
    <?php echo input_file_tag("file"); ?>

    <?php echo submit_tag("Upload", array(
      "id" => "newfilebutton",
      "onclick" => "if($('file').value=='') 
        { alert('".__('Please choose a file first')."');return false; }" ))
    ?>
  </div>
</form>

<div id="image_block"></div>

</body>
</html>

