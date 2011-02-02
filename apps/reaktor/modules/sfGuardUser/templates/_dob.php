<?php 

/**
 * Date of birth partial
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
 /*
 $date = $sf_guard_user->getDob();
$date = $date?$date:date('') ;

echo input_date_tag('sf_guard_user[dob]', $date, array(
    'rich'=>false,
    'culture'=>$sf_user->getCulture(),
    'year_end'=>date('Y'),
    'year_start'=>date('Y')-100,
    'date_seperator'=>'.',
    'include_custom'=> array('day'=>__('--'), 'month'=>__('--'), 'year'=>__('--')))) ;

*/
  $theday = 0;
  $day_arr = array();
  $themonth = 0;
  $month_arr = array();
  $theyear = 0;
  $year_arr = array();
  
  //echo $sf_guard_user->getId();
  
  if ($sf_guard_user->getDob() != '')
  {
	  $theday = date('j', strtotime($sf_guard_user->getDob()));
	  $themonth = date('n', strtotime($sf_guard_user->getDob()));
	  $theyear = date('Y', strtotime($sf_guard_user->getDob()));
  }
  
  if ($this->getContext()->getRequest()->getError('sf_guard_user{dob}') != '')
  {
  	$theday = 0;
    $themonth = 0;
    $theyear = 0;
  }
  
  $day_arr[0] = '--';
  for ($cc=1;$cc<=31;$cc++)
  {
  	$day_arr[$cc] = $cc; 
  }

  $month_arr[0] = '--';
  for ($cc=1;$cc<=12;$cc++)
  {
    $month_arr[$cc] = date('F', mktime(0, 0, 1, $cc)); 
  }

  $year_arr[0] = '--';
  for ($cc=date('Y');$cc>=(date('Y') - 100);$cc--)
  {
    $year_arr[$cc] = $cc; 
  }
  
  echo select_tag('sf_guard_user[dob][day]', options_for_select($day_arr, $theday));
  echo select_tag('sf_guard_user[dob][month]', options_for_select($month_arr, $themonth));
  echo select_tag('sf_guard_user[dob][year]', options_for_select($year_arr, $theyear));