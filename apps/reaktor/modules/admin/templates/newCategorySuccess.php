<?php
/**
 * Page for adding a new category with translations
 *
 * PHP Version 5
 *
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

reaktor::setReaktorTitle(__('Language settings')); 

?>

<?php include_component("sfTransUnit", "newTranslationForm", 
  array("redirect" => "@listcategories", 
        "translateObject" => "Category",
        "translateField" => "Name")); ?>