<?php 
/**
 * Partial for linking related artwork
 *
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

use_helper('Javascript');
?>

<?php echo javascript_tag("
function listartworkClose(){
  document.getElementById('listArtworkMaster').style.display = 'none';
}
") ?>


<div id="relate_artwork_tag">
    <?php //Show spinning reaktor logo only when submitting ?>
    <div id = "relate_artwork_ajax_indicator" style="display: none">
      &nbsp;<?php echo image_tag('spinning18x18.gif', 'alt=spinning18x18'); ?>
    </div>
 
  <?php if ($usercanedit && $editmode): ?>

  <div class="smallborder padbottom">
    <p class="mediumindent"><?php echo __("Search for artworks to relate to by tag"); ?>
      <?php if ($sf_user->hasCredential("staff")): ?>
        <br /><?php echo __("(Note: You can only relate to your own artworks)"); ?>
      <?php endif; ?>:
<div class="relate_artwork_submit" >
      <?php echo form_remote_tag(array(
  'update'   => 'listArtwork',
  'url'      => '@AJAX_browse_unrelated_artworks?id='.$artwork->getId().'&autocompleter=false',
	'complete' => "Element.show('listArtworkMaster');",
	'script'   => true,
  ),
  array("name" => "relate_form", "id" => "relate_form")) ?>
      
    <?php echo input_auto_complete_tag('filter', '',
    '@AJAX_browse_unrelated_artworks?id='.$artwork->getId().'&autocompleter=true',
    array("class" => "mediumindent",'onkeypress'=>'if(event.keyCode!=9) listartworkClose();' ),
    array("frequency" => 0.2 )
  );?> <?php echo submit_tag(__('Search'), array( "name"    => "search_related"  )); ?>
</div>

<div id="listArtworkMaster"  style="position: absolute;background:silver;display:none;">
<div id="listArtwork" class="mediumindent" onmousedown="" ></div>
<?php echo link_to( __("Cancel"),'',array('onclick'=>'listartworkClose(); return false;')) ?>
</div>

      
      </form>
      <div id="suggest_artwork"></div>
    </p>
  </div>
  <?php endif; ?>

  <?php //List of already related artwork ?>
  <div id = "see_also_block">
    <?php include_component('artwork', 'seeAlso', array(
      'artwork'     => $artwork, 
      'update'      => 'relate_artwork_tag',
      'editmode'    => $editmode, 
      'usercanedit' => $usercanedit)); ?>
  </div>
  
</div>

