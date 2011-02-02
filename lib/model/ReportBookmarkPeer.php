<?php

/**
 * Subclass for performing query and update operations on the 'report_bookmark' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ReportBookmarkPeer extends BaseReportBookmarkPeer
{
  /**
   * Get all the reports in a multidimensional array grouped by report type
   *
   * @return array of arrays containing reportBookmark objects
   */
  public static function getAllGroupedByType()
  {
    // Get all the reports
    $c = new Criteria();
    $c->addAscendingOrderByColumn(self::LIST_ORDER);
    $reports     = self::doSelect($c);
    $resultArray = array();
    
    foreach ($reports as $report)
    {
      $resultArray[$report->getType()][$report->getId()] = $report;
    }
    
    return $resultArray;
  }
}
