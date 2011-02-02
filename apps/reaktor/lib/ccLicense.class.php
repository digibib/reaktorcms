<?php
class ccLicense extends sfFeedLicense
{
  public function __construct($style = null)
  {
    $this->init($style);
  }

  public function init($style = null)
  {
    if ($style && !is_string($style))
    {
      throw new Exception("Unknown style type");
    }
    switch($style)
    {
      case "by":
      case "by-sa":
      case "by-nd":
      case "by-nc":
      case "by-nc-sa":
      case "by-nc-nd":
        parent::initialize(array(
          "href" => "http://creativecommons.org/licenses/{$style}/3.0/",
          "type" => "text/html",
        ));
        break;

      default:
        parent::initialize(array());
    }

  }
}

