<?php

/**
 * Subclass for performing query and update operations on the 'file_mimetype' table.
 *
 * 
 *
 * @package lib.model
 */ 
class FileMimetypePeer extends BaseFileMimetypePeer
{
  public static function retrieveByMimetype($type)
  {
    $c = new Criteria;
    $c->add(FileMimetypePeer::MIMETYPE, $type);
    return parent::doSelectOne($c);
  }
}

