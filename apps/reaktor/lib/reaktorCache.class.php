<?php

class reaktorCache
{
  const DEFAULT_LIFETIME = 86400;

  private static $APC = null;
  private static $_instance = null;

  private $local = null;
  private $that = null;
  private $lifetime = self::DEFAULT_LIFETIME;
  
  /**
   * Initializes reaktorCache object for $key
   *
   * @param string $key The unique key identifying this cache store
   * 
   * @return reaktorCache
   */
  public static function singleton($key)
  {
    static $init = false;

    if (isset(self::$_instance[$key]) === false)
    {
      if ($init === false)
      {
        self::$APC = (bool)function_exists("apc_store");
        $init = true;
      }

      $bt = debug_backtrace();
      $obj = $bt[1] instanceof sfComponents ? $bt[1] : null;

      self::$_instance[$key] = new self($key, $obj);
    }

    return self::$_instance[$key];
  }

  /**
   * Remove an item from the cache based on key
   *
   * @param string $key the unique key
   * 
   * @return boolean true on success (key found)
   */
  public static function delete($key)
  {
    $retval = false;

    if (isset(self::$_instance[$key]) === true)
    {
      self::$_instance[$key]->shouldUpdate = false;
      unset(self::$_instance[$key]);
      $retval = true;
    }

    if (self::$APC || self::$APC == null)
    {
      if (function_exists("apc_delete"))
      {
        apc_delete(sfProcessCache::getPrefix().$key);
      }
      $retval = true;
    }
    return $retval;
  }
  
  /**
   * Deletes items from the cache similar to $key
   * 
   * @param string $key    reaktorCache key
   * @return integer       The deleted key count
   */
  public static function deleteSimilar($key)
  {
    if (self::$APC == false)
    {
      return false;
    }

    $keys = array();
    $cached_keys = @apc_cache_info('user');
    if (!is_array($cached_keys)) { return false;} // To avoid functional test fails
    foreach ($cached_keys['cache_list'] as $i => $ck)
    {
      if (strpos($ck['info'], $key) !== false)
      {
        $keys[] = substr($ck['info'], strpos($ck['info'], '_') + 1);
      }
    }

    $retval = 0;
    foreach ($keys as $retval => $key)
    {
      self::delete($key);
      ++$retval;
    }
    return $retval;
  }
  
  /**
   * Constructs the reaktorCache object
   * 
   * @param mixed $key 
   * @param sfComponents $that 
   * @return void
   */
  private function __construct($key, sfComponents $that = null)
  {
    $this->key = $key;
    $this->that = $that;
    

    $this->local = (self::$APC ?
      sfProcessCache::get($key) :
      ($that = $this->that && $that->hasFlash($key) ?
        $that->getFlash($key) :
        null
      )
    );
    $this->shouldUpdate = ! (bool) $this->local;
  }

  /**
   * Retrieves the cached item
   * 
   * @return mixed
   */
  public function get()
  {
    return $this->local;
  }

  /**
   * Throws $local into in-memory cache
   * NOTE: You cannot overwrite the previous cache
   * 
   * @param mixed $local 
   * @param int $lifetime 
   * @return void
   */
  public function set($local, $lifetime = self::DEFAULT_LIFETIME)
  {
    $this->lifetime = $lifetime;
    
    if ($this->shouldUpdate === false)
    {
      return;
    }

    self::$APC ? sfProcessCache::set($this->key, $local, $lifetime) : ($that = $this->that && $that->setFlash($this->key, $local, false));
    $this->local = $local;
  }

  /**
   * Updates the cache with new values
   * 
   * @param mixed $local 
   * @param mixed $lifetime 
   * @return void
   */
  public function update($local, $lifetime = self::DEFAULT_LIFETIME)
  {
    self::$APC ? sfProcessCache::set($this->key, $local, $lifetime) : ($that = $this->that && $that->setFlash($this->key, $local, false));
    $this->local = $local;
  }

  /**
   * Wether or not updating of the cache is nessicery
   * 
   * @return bool
   */
  public function shouldUpdate()
  {
    return $this->shouldUpdate;
  }

  /**
   * Updates the lifetime of the cache
   * 
   * @return void
   */
  public function __destruct()
  {
    if ($this->shouldUpdate === false)
    {
      return;
    }

    self::$APC ?
      sfProcessCache::set($this->key, $this->local, $this->lifetime) :
      ($that = $this->that && $that->setFlash($this->key, $this->local));
  }
}

