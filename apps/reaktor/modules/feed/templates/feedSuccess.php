<?php
 /**
 * Render an RSS feed
 * 
 * This file should not need to be modified, and any extra output in here could cause the feed to fail.
 * It takes the feed from the action and renders an xml file from it.
 * 
 * - $feed : The feed object containing the entire feed
 * 
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

decorate_with(false);
echo $feed->asXml();
