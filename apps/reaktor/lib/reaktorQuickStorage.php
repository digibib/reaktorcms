<?php

class reaktorQuickStorage
{
  private static $local = array();
  
  /**
   * Returns the stored item
   * 
   * @param mixed $key    A key to access
   * @return mixed
   */
  public static function get($key)
  {
    return isset(self::$local[$location]) ? self::$local[$location] : null;
  }

  /**
   * Stores an item in-memory
   * 
   * @param mixed $key    A key to assign the value to
   * @param mixed $value  A value to store in memory
   * @return mixed        The value stored
   */
  public static function set($key, $value)
  {
    self::$local[$key] = $value;
    sfProcessCache::set($key, $value);
    return $value;
  }
}

