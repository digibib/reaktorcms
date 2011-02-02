<?php
/**
 * The content server is used to display all protected content on the site. Credentials and
 * availability are checked before anything is sent to the browser for rendering, should anything fail,
 * a failure image is displayed. All the logic is carried out in the action file, there is no template output
 * as the content is effectively streamed directly to the browser.
 * 
 * This template is only used for testing when debug output is required
 * Normally this template should never load as the action ends with a redirect or die()/exit()
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
?>