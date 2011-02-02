<?php
/**
 * Components for reporting 
 *
 * PHP Version 5
 *
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

/**
 * Components for reporting 
 *
 * PHP Version 5
 *
 * @author    Russ <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
class reportsComponents extends sfComponents
{
  /**
   * Generate the result graph
   * 
   * @return null
   */
  function executeResultGraph()
  {

  }
  
  /**
   * Show a list of reports that are relevant to this report page 
   *
   * @return null
   */  
  function executeSavedReportsFloatBox()
  {
    // If a value has been posted, we should check if it's a report we know about, or offer to save it
    if ($this->getRequestParameter("commit"))
    {
      $queryArray  = explode("?", sfRouting::getInstance()->getCurrentInternalUri());     
      $queryString = $queryArray[1];
      
      //Remove all unnecessary keys before storing
      $url_parameters = $this->getController()->convertUrlStringToParameters('admin/reports?'.$queryString);
      $url = '';
      foreach ($url_parameters[1] as $key => $value)
      {
        if($value && $key != 'action' && $key != 'module' 
                  && $key != 'sf_culture' && $key != 'commit' 
                  && $key != 'report_type' && $value != '0' )
        {
          $url.='/'.$key.'/'.$value;
        }
      }      
      $queryString = $url;
      
      // Now we take a look in the DB to see if we already have an identical report
      $c = new Criteria();
      $c->add(ReportBookmarkPeer::ARGS, $queryString);
      $savedReport = ReportBookmarkPeer::doSelectOne($c);
    }
    else
    {
      $savedReport = false;
    }
    
    // Get all the reports up to the limit in config, except the one we are looking at from the query above
    $c = new Criteria();
    $c->setLimit(sfConfig::get("app_reports_bookmarks_to_show", 6));
    $c->addAscendingOrderByColumn(ReportBookmarkPeer::LIST_ORDER);
    $c->add(ReportBookmarkPeer::TYPE, $this->type);
    if ($savedReport)
    {
      $c->add(ReportBookmarkPeer::ID, $savedReport->getId(), Criteria::NOT_EQUAL);
    }
    
    $bookmarks = ReportBookmarkPeer::doSelect($c);
    
  $this->report_title=$this->getContext()->getI18N()->__('artwork', '', 'messages');  
  $this->report_type=$this->getContext()->getI18N()->__($this->type,'','');  
    
    // Send the required values to the template
    $this->bookmarks   = $bookmarks;
    $this->savedReport = $savedReport; 
  }
}
