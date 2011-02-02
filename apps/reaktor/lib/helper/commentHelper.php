<?php

/**
 * Helper for different comment tasks
 * PHP Version 5
 *
 * @author    Ole-Petter Wikene <olepw@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

function zeroOrOne()
{
  static $flip = 1;
  $flip = !$flip;
  return (int)$flip;
}
?>
