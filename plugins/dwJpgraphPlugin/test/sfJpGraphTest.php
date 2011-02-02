<?php

/*
 * @package    symfony
 * @subpackage dwJgraphPlugin
 * @author     Dustin Whittle <dustin.whittle@symfony-project.com>
 * @author     Jordi Backx <jordi@westsitemedia.nl>
 * @version    SVN: $Id: sfJpGraphTest.php 6910 2008-01-03 07:03:55Z dwhittle $
 */

require_once(dirname(__FILE__).'/../../../test/bootstrap/unit.php');
require_once(dirname(__FILE__).'/../lib/sfJpGraph.class.php');

$t = new lime_test(2, new lime_output_color());
$sfJpGraph = new sfJpGraph();

?>