<?php
class sfFeedLicense
{
  private
    $type,
    $href;

  public function __construct($item_array = array())
  {
    if($item_array)
    {
      $this->initialize($item_array); 
    }
  }
  
  /**
   * Sets the feed image parameters, based on an associative array
   *
   * @param array an associative array
   *
   * @return sfFeedImage the current sfFeedImage object
   */
  public function initialize($item_array)
  {
    $this->setType(isset($item_array['type']) ? $item_array['type'] : '');
    $this->setHref(isset($item_array['href']) ? $item_array['href'] : '');

    return $this;
  }

  public function setType($type)
  {
    $this->type = $type;
    return $this;
  }
  public function getType()
  {
    return $this->type;
  }

  public function setHref($href)
  {
    $this->href = $href;
    return $this;
  }

  public function getHref()
  {
    return $this->href;
  }

}

