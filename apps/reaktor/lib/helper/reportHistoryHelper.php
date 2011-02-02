<?php
/**
 * Helper for different array task not directly covered by SPL
 * PHP Version 5
 *
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 * 
 */

function displayReportHistory($historyArray = array(), $tooltipFormat = true)
{
  $block = "<div class = 'history_list'><table width='100%'>";
  foreach($historyArray as $aHistoryRow)
  {
    $block .= "<tr>";
    $block .= "<td>".$aHistoryRow->getSfGuardUser()->getUserName()."</td>";
    $block .= "<td align='right'>(".date("d/m/Y H:i", strtotime($aHistoryRow->getCreatedAt())).")</td>";
    $block .= "</tr>";
  }
  $block .= "</table></div>";
  
  if ($tooltipFormat)
  {
    $block = str_replace("'", "\\'", $block);
  }
  
  return $block;
}