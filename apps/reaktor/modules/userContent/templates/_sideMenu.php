<?php
/**
 * The grey menu sidebar for the content management section
 *
 * PHP Version 5
 *
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

reaktor::addJsToFooter("$('content_manager_sidebar').setStyle({height: $('sidebar').offsetHeight + 'px'});");
?>

<div id="content_manager_sidebar" class="withstripe" style="float: left;">
	<?php include_component("userContent", "contentManagerSidebarAjaxblock"); ?>
</div>