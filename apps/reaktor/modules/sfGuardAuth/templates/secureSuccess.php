<?php
/**
 * Default secure template for accessing restricted action
 *
 * PHP Version 5
 *
 * @author    Fabiel <fabien@symfony-project.com>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

reaktor::setReaktorTitle(__('Access denied')); ?>

<p><?php echo __("You don't have the requested permission to access this page."); ?></p>