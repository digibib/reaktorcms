<?php
/**
 * Menu bar partial containing all the main site links that the users will use to navigate the site from a top level
 * Subreaktors are automatically iterated here across the menu bar, and lokalreaktors are automatically appended
 * to the lokalreaktor list.
 * 
 * Currently selected menu items will be designated the class "selected" which can be modified in the main css file,
 * 
 * Add more menu items by using the subreaktor administartion section
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

$lokalreaktor = $sf_request->getAttribute("lokalreaktor");
$subreaktor = $sf_request->getAttribute("subreaktor");

?>
<div id="menu_bar">
  <?php if ($lokalreaktor): ?>
    <?php echo link_to(__('Home'), '/' . Subreaktor::getProvidedLokalReference(), 
               ((!$subreaktor) ? array('class' => 'selected') : array())); ?>
  <?php else: ?>
    <?php echo link_to(__('Home'), '/', ((!$subreaktor
               && sfContext::getInstance()->getActionName() == 'index' 
               && sfContext::getInstance()->getModuleName() == 'home') ? array('class' => 'selected') : array())); ?>
  <?php endif; ?>
    <?php foreach (Subreaktor::getAll() as $aSubReaktor): ?>
      <?php if ($aSubReaktor->getLokalReaktor() == false && ($aSubReaktor->getLive() 
                || ($aSubReaktor->getReference() == Subreaktor::getProvided() && $sf_user->hasCredential('subreaktoradministrator')))): ?>
        &nbsp;&nbsp;
        <?php echo link_to($aSubReaktor->getName(), '/' . (($lokalreaktor) ? $lokalreaktor->getReference() . '-' : '') .
                          $aSubReaktor->getReference(), 
                          ((($subreaktor && $subreaktor->getReference() == $aSubReaktor->getReference())) 
                          ? array('class' => 'selected') : array())); ?>
      <?php endif; ?>
    <?php endforeach; ?>
  <div id="lokalreaktor_link" class="dropdown_menu_link">
    <a href="#" onmouseout="$('lokalreaktor_menu').hide();" onmouseover="$('lokalreaktor_menu').show();" class="dropdown_menu_link_container"><?php if (isset($lokalreaktor)): echo $lokalreaktor->getName(); else: echo __('LokalReaktor'); endif; ?></a>
    <br />
    <div style="display: none;" id="lokalreaktor_menu" class="dropdown_menu normal" onmouseout="$('lokalreaktor_menu').hide();" onmouseover="$('lokalreaktor_menu').show();">
      <ul>
		    <?php foreach (Subreaktor::getAll() as $aSubReaktor): ?>
		      <?php if ($aSubReaktor->getLokalReaktor() && $aSubReaktor->getLive()): ?>
            <?php if (!(Subreaktor::getProvidedLokalreaktor() instanceof Subreaktor && Subreaktor::getProvidedLokalReference() == $aSubReaktor->getReference())): ?>
		          <li><?php echo link_to($aSubReaktor->getName(), '/' . $aSubReaktor->getReference()); ?></li>
            <?php endif; ?>
		      <?php endif; ?>
		    <?php endforeach; ?>
        <?php if (Subreaktor::getProvidedLokalreaktor() instanceof Subreaktor): ?>
          <li><?php echo link_to(__('Reaktor frontpage'), '@home'); ?></li>
        <?php endif; ?>
      </ul>
	  </div>
 </div>
</div>
