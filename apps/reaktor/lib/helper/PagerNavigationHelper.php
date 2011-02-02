<?php 

/**
 * Outputs a regular navigation navigation.
 * It outputs a series of links to the first, previous, next and last page
 * as well as to the 5 pages surrounding the current page. This function is 
 * overridden in order to set the style of the current page in the pagination
 * to bold. 
 *
 * @param  object sfPager object of the current pager 
 * @param  string 'module/action' or '@rule' of the paginated action
 * @return string XHTML code containing links
 */
function pager_navigation($pager, $uri)
{
  $navigation = '';
 
  if ($pager->haveToPaginate())
  {  
    $uri .= (preg_match('/\?/', $uri) ? '&' : '?').'page=';
 
    // First and previous page
    if ($pager->getPage() != 1)
    {
      $navigation .= link_to(image_tag('/sf/images/sf_admin/first.png', 'align=middle'), $uri.'1');
      $navigation .= link_to(image_tag('/sf/images/sf_admin/previous.png', 'align=middle'), $uri.$pager->getPreviousPage()).'&nbsp;';
    }
 
    // Pages one by one
    $links = array();
    foreach ($pager->getLinks() as $page)
    {
      $links[] = link_to_unless($page == $pager->getPage(), $page, $uri.$page, array('class' => 'navigation'));
    }
    $navigation .= join('&nbsp;&nbsp;', $links);
 
    // Next and last page
    if ($pager->getPage() != $pager->getLastPage())
    {
      $navigation .= '&nbsp;'.link_to(image_tag('/sf/images/sf_admin/next.png', 'align=middle'), $uri.$pager->getNextPage());
      $navigation .= link_to(image_tag('/sf/images/sf_admin/last.png', 'align=middle'), $uri.$pager->getLastPage());
    }
 
  }
  return $navigation;
}
