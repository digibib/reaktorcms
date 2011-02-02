<?php
/**
 * The page logos and image maps which appear on top left of every page in the page header
 * Admin mode and the admin logo are set in the admin filter which is run on every page load, so the configuration
 * option "app_admin_logo" is dynamic (currently it will be set to administrator or redaksjon)
 * 
 * PHP Version 5
 *
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

$lokalreaktor = Subreaktor::getProvidedLokalreaktor();
$subreaktor = Subreaktor::getProvidedSubreaktor();
?>

<?php if (sfConfig::get("admin_mode")): ?>
  <?php echo image_tag(sfConfig::get("app_admin_logo", "logoAdmin.gif"), array("id" => "header_image", "usemap" => "#admin_map")); ?>
  <map name = "admin_map" id="header_map">
    <area shape="rect" coords="0, 0, 166, 39" href="<?php echo url_for("@home"); ?>" title="<?php echo __('%site_title% home', array("%site_title%" => sfConfig::get("app_main_title"))); ?>" alt="<?php echo __('%site_title% home', array("%site_title%" => sfConfig::get("app_main_title"))); ?>" />
    <area shape="rect" coords="178, 0, 400, 39" href="<?php echo url_for("@admin_home"); ?>" title="<?php echo __("Admin portal"); ?>" alt="<?php echo __("Admin portal"); ?>" />  
  </map>
<?php elseif (sfConfig::get("mypage_mode")): ?>
  <?php echo image_tag("logoMinside.gif", array("id" => "header_image", "usemap" => "#user_map")); ?>
  <map name = "user_map" id="header_map">
    <area shape="rect" coords="0, 0, 166, 39" href="<?php echo url_for("@home"); ?>" title="<?php echo __('%site_title% home', array("%site_title%" => sfConfig::get("app_main_title"))); ?>" alt="<?php echo __('%site_title% home', array("%site_title%" => sfConfig::get("app_main_title"))); ?>" />
    <area shape="rect" coords="178, 0, 400, 39" href="<?php echo reaktor_url_for("@mypage?user=".($sf_params->get("user", $sf_params->get("username", $sf_user->getUsername())))); ?>" title="<?php echo __("My page"); ?>" alt="<?php echo __("My page"); ?>" />  
  </map>  
<?php elseif ($lokalreaktor): ?>
  <?php echo image_tag("logo" . ucfirst($lokalreaktor->getReference()) . ".gif", array("id" => "header_image", "usemap" => "#header_map")); ?>
  <map name = "header_map" id = "header_map">
    <area shape="rect" coords="0, 0, 166, 39" href="<?php echo url_for("@home"); ?>" title="<?php echo __('%site_title% home', array("%site_title%" => sfConfig::get("app_main_title"))); ?>" alt="<?php echo __('%site_title% home', array("%site_title%" => sfConfig::get("app_main_title"))); ?>" />
    <area shape="rect" coords="178, 0, 400, 39" href="<?php echo url_for("@subreaktorhome?subreaktor=".$lokalreaktor->getReference());?>" title="<?php echo __("%site_title% home", array("%site_title%" => $lokalreaktor->getName())); ?>" alt="<?php echo __("%site_title% home", array("%site_title%" => $lokalreaktor->getName())); ?>" />  
  </map>
<?php elseif ($subreaktor): ?>
  <?php echo image_tag("logo" . ucfirst($subreaktor->getReference()) . ".gif", array("id" => "header_image", "usemap" => "#header_map")); ?>
  <map name = "header_map" id="header_map">
    <area shape="rect" coords="0, 0, 166, 39" href="<?php echo url_for("@home"); ?>" title="<?php echo __('%site_title% home', array("%site_title%" => sfConfig::get("app_main_title"))); ?>" alt="<?php echo __('%site_title% home', array("%site_title%" => sfConfig::get("app_main_title"))); ?>" />
    <area shape="rect" coords="178, 0, 400, 39" href="<?php echo url_for("@subreaktorhome?subreaktor=".$subreaktor->getReference()); ?>" title="<?php echo __("%site_title% home", array("%site_title%" => $subreaktor->getName())); ?>" alt="<?php echo __("%site_title% home", array("%site_title%" => $subreaktor->getName())); ?>" />  
  </map>  
<?php else: ?>
  <?php echo image_tag("logoForside.gif", array("id" => "header_image", 'usemap' => '#forsidemap', 'border' => 0)); ?>
  <map name="forsidemap" id="forsidemap">
    <area shape="rect" coords="0,0,166,38" href="<?php echo url_for("@home"); ?>" title="<?php echo __('%site_title% home', array("%site_title%" => sfConfig::get("app_main_title"))); ?>" alt="<?php echo __('%site_title% home', array("%site_title%" => sfConfig::get("app_main_title"))); ?>" />
    <area shape="rect" coords="178,12,213,38" href="<?php echo url_for("@subreaktorhome?subreaktor=foto"); ?>" title="<?php echo Subreaktor::getByReference('foto')->getName(); ?>" alt="<?php echo Subreaktor::getByReference('foto')->getName(); ?>" />
    <area shape="rect" coords="215,13,260,38" href="<?php echo url_for("@subreaktorhome?subreaktor=tegning"); ?>" title="<?php echo Subreaktor::getByReference('tegning')->getName(); ?>" alt="<?php echo Subreaktor::getByReference('tegning')->getName(); ?>" />
    <area shape="rect" coords="261,13,296,38" href="<?php echo url_for("@subreaktorhome?subreaktor=film"); ?>" title="<?php echo Subreaktor::getByReference('film')->getName(); ?>" alt="<?php echo Subreaktor::getByReference('film')->getName(); ?>" />
    <area shape="rect" coords="300,13,336,38" href="<?php echo url_for("@subreaktorhome?subreaktor=lyd"); ?>" title="<?php echo Subreaktor::getByReference('lyd')->getName(); ?>" alt="<?php echo Subreaktor::getByReference('lyd')->getName(); ?>" />
    <area shape="rect" coords="340,13,375,38" href="<?php echo url_for("@subreaktorhome?subreaktor=tegneserier"); ?>" title="<?php echo Subreaktor::getByReference('tegneserier')->getName(); ?>" alt="<?php echo Subreaktor::getByReference('tegneserier')->getName(); ?>" />
    <area shape="rect" coords="378,13,408,38" href="<?php echo url_for("@subreaktorhome?subreaktor=tekst"); ?>" title="<?php echo Subreaktor::getByReference('tekst')->getName(); ?>" alt="<?php echo Subreaktor::getByReference('tekst')->getName(); ?>" />
  </map>
<?php endif; ?>
