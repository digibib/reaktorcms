<?php
/**
 * Class wrapper for accessing needed info from getID3 libraries
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

//Autoloading not working on lab for some reason
require_once SF_ROOT_DIR . DIRECTORY_SEPARATOR . "plugins/getId3Plugin/lib/getid3.php";

/**
 * Class wrapper for accessing needed info from getID3 libraries
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */
class audioInfo
{

  /**
   * Result
   *
   * @var array
   */
  var $result = null;
  
  /**
   * Info
   *
   * @var array
   */
  var $info   = null;

  /**
   * Class constructor
   *
   * @return void
   */
  function __construct() 
  {

    // Initialize getID3 engine
    $this->getID3                         = new getID3;
    $this->getID3->option_md5_data        = true;
    $this->getID3->option_md5_data_source = true;
    $this->getID3->encoding               = 'UTF-8';
  }

  /**
  * Extract information - only public function
  *
  * @param string $file Audio file to extract info from.
  * 
  * @access public
  * @return array info array
  */
  function info($file) 
  {

    // Analyze file
    $this->info = $this->getID3->analyze($file);

    // Exit here on error
    if (isset($this->info['error'])) 
    {
      return array ('error' => $this->info['error']);
    }

    // Init wrapper object
    $this->result                    = array ();
    $this->result['format_name']     = @$this->info['fileformat'].'/'.@$this->info['audio']['dataformat'].(isset($this->info['video']['dataformat']) ? '/'.@$this->info['video']['dataformat'] : '');
    $this->result['encoder_version'] = @$this->info['audio']['encoder'];
    $this->result['encoder_options'] = @$this->info['audio']['encoder_options'];
    $this->result['bitrate_mode']    = @$this->info['audio']['bitrate_mode'];
    $this->result['channels']        = @$this->info['audio']['channels'];
    $this->result['sample_rate']     = @$this->info['audio']['sample_rate'];
    $this->result['bits_per_sample'] = @$this->info['audio']['bits_per_sample'];
    $this->result['playing_time']    = @$this->info['playtime_seconds'];
    $this->result['avg_bit_rate']    = @$this->info['audio']['bitrate'];
    $this->result['tags']            = @$this->info['tags'];
    
    // Post getID3() data handling based on file format
    $method = @$this->info['fileformat'].'Info';
    if (@$this->info['fileformat'] && method_exists($this, $method)) 
    {
      $this->$method();
    }

    return $this->result;
  }

  /**
  * post-getID3() data handling for AAC files.
  *
  * @access private
  * @return array result
  */
  function aacInfo() 
  {
    $this->result['format_name'] = 'AAC';
  }

  /**
  * post-getID3() data handling for Wave files.
  *
  * @access private
  * @return array result
  */
  function riffInfo() 
  {
    if ($this->info['audio']['dataformat'] == 'wav') 
    {
      $this->result['format_name'] = 'Wave';
    } 
    else if (ereg('^mp[1-3]$', $this->info['audio']['dataformat'])) 
    {
      $this->result['format_name'] = strtoupper($this->info['audio']['dataformat']);
    } 
    else 
    {
      $this->result['format_name'] = 'riff/'.$this->info['audio']['dataformat'];
    }
  }

  /**
  * * post-getID3() data handling for FLAC files.
  *
  * @access private
  * @return array result
  */
  function flacInfo() 
  {
    $this->result['format_name'] = 'FLAC';
  }

  /**
  * post-getID3() data handling for Monkey's Audio files.
  *
  * @access private
  * @return array result
  */
  function macInfo() 
  {
    $this->result['format_name'] = 'Monkey\'s Audio';
  }

  /**
  * post-getID3() data handling for Lossless Audio files.
  *
  * @access private
  * @return array result
  */
  function laInfo() 
  {
    $this->result['format_name'] = 'La';
  }

  /**
  * post-getID3() data handling for Ogg Vorbis files.
  *
  * @access private
  * @return array result
  */

  function oggInfo() 
  {
    if ($this->info['audio']['dataformat'] == 'vorbis') 
    {

      $this->result['format_name'] = 'Ogg Vorbis';

    } 
    else if ($this->info['audio']['dataformat'] == 'flac') 
    {

      $this->result['format_name'] = 'Ogg FLAC';

    } 
    else if ($this->info['audio']['dataformat'] == 'speex') 
    {

      $this->result['format_name'] = 'Ogg Speex';

    } else 
    {

      $this->result['format_name'] = 'Ogg '.$this->info['audio']['dataformat'];

    }
  }

  /**
  * post-getID3() data handling for Musepack files.
  *
  * @access private
  * @return array result
  */
  function mpcInfo() 
  {
    $this->result['format_name'] = 'Musepack';
  }

  /**
  * post-getID3() data handling for MPEG files.
  *
  * @access private
  * @return array result
  */
  function mp3Info() 
  {
    $this->result['format_name'] = 'MP3';
  }

  /**
  * post-getID3() data handling for MPEG files.
  *
  * @access private
  * @return array result
  */

  function mp2Info() 
  {
    $this->result['format_name'] = 'MP2';
  }


  /**
  * post-getID3() data handling for MPEG files.
  *
  * @access private
  * @return array result
  */
  function mp1Info() 
  {
    $this->result['format_name'] = 'MP1';
  }

  /**
  * post-getID3() data handling for WMA files.
  *
  * @access private
  * @return array result
  */
  function asfInfo() 
  {
    $this->result['format_name'] = strtoupper($this->info['audio']['dataformat']);
  }

  /**
  * post-getID3() data handling for Real files.
  *
  * @access private
  * @return array result
  */
  function realInfo() 
  {
    $this->result['format_name'] = 'Real';
  }

  /**
  * post-getID3() data handling for VQF files.
  *
  * @access private
  * @return array result
  */
  function vqfInfo() 
  {
    $this->result['format_name'] = 'VQF';
  }
}


?>