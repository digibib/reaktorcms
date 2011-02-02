<?php

/**
 * Subclass for representing a row from the 'article_file' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ArticleFile extends BaseArticleFile
{
  public function upload($from)
  {
    if (!move_uploaded_file($from, $this->getPath(). parent::getFilename()))
    {
      throw new Exception("Cannot moved the uploaded file");
    }
  }
  public function getFilename()
  {
    // Remove the path
    $fn = basename(parent::getFilename());
    // Remove the first two underscores
    if (substr_count($fn, "_") < 2)
    {   
      return;
    }   
    list($a, $b, $fn) = explode("_", $fn, 3); 
    $prefix = $a. "_" . $b; 

    return $fn;
  }

  public function getRealFilename()
  {
    return parent::getFilename();
  }

  public function getDirectLink()
  {
    return sfConfig::get("app_upload_attachment_dir", "attachment") . "/" . parent::getFilename();
  }

  public function getFullPath()
  {
    return $this->getPath() . parent::getFilename();
  }

  public function __toString()
  {
    return $this->getFilename();
  }

}

