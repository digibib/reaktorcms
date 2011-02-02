<?php
/**
 * double (input) multiple-selection-list helper
 *  
 * PHP version 5
 * 
 * @author    Hannes Magnusson <bjori@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */


function _remove_recursive_from_list($remove, $list)
{
  $retval = $list;
  foreach($list as $key => $element) {
    if (is_array($element)) {
      $retval[$key] = _remove_recursive_from_list($remove, $element);
    } else {
      if (in_array($element, (array)$remove)) {
        unset($retval[$key]);
      }
    }
  }
  return $retval;
}

/**
 * Takes two arrays to create "add/remove" list boxes
 * 
 * @param array $list      All elements to list
 * @param array $pick      Choicen elements (will be removed from $list)
 * @param array $options   HTML options array
 * @return string          The generated html
 */
function reaktor_double_list(array $list, array $pick = array(), array $options = array())
{
  $options = _parse_attributes($options);

  $options['multiple'] = true;
  $options['class'] = 'sf_admin_multiple';
  if (!isset($options['size']))
  {
    $options['size'] = 10;
  }
  $label_all   = __(isset($options['unassociated_label']) ? $options['unassociated_label'] : 'Unassociated');
  $label_assoc = __(isset($options['associated_label'])   ? $options['associated_label']   : 'Associated');

  $list = _remove_recursive_from_list($pick, $list);

  $name = "lokalreaktor_residence";
  $name1 = 'unassociated_'.$name;
  $name2 = 'associated_'.$name;
  $select1 = select_tag($name1, options_for_select($list, '', $options), $options);
  $options['class'] = 'sf_admin_multiple-selected';
  $select2 = select_tag($name2, options_for_select($pick, '', $options), $options);

  $html =
'<div>
  <div style="float: left">
    <div style="font-weight: bold; padding-bottom: 0.5em">%s</div>
    %s
  </div>
  <div style="float: left">
    %s<br />
    %s
  </div>
  <div style="float: left">
    <div style="font-weight: bold; padding-bottom: 0.5em">%s</div>
    %s
  </div>
  <br style="clear: both" />
</div>
';

  $response = sfContext::getInstance()->getResponse();
  $response->addJavascript(sfConfig::get('sf_prototype_web_dir').'/js/prototype');
  $response->addJavascript(sfConfig::get('sf_admin_web_dir').'/js/double_list');

  return sprintf($html,
    $label_all,
    $select1,
    submit_image_tag(sfConfig::get('sf_admin_web_dir').'/images/next.png', "style=\"border: 0\" onclick=\"double_list_move(\$('{$name1}'), \$('{$name2}')); return false;\""),
    submit_image_tag(sfConfig::get('sf_admin_web_dir').'/images/previous.png', "style=\"border: 0\" onclick=\"double_list_move(\$('{$name2}'), \$('{$name1}')); return false;\""),
    $label_assoc,
    $select2
  );
}


