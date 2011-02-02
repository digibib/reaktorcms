<?php

/**
 * Unit tests for the flash helper
 * 
 * PHP version 5
 * 
 * @author    Kjell-Magne Oierud <kjellm@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version   SVN: $Id: flashHelperTest.php 524 2008-03-28 00:58:49Z kjellm $
 */


require dirname(__FILE__).'/../bootstrap/unit.php';
require_once dirname(__FILE__).'/../../apps/reaktor/lib/helper/flashHelper.php';

$t = new lime_test(2, new lime_output_color());



$t->diag('flash_movie_player()');
$expected = <<<HERE
<object data="/flowplayer/FlowPlayerLight.swf" width="400" height="250"
        type="application/x-shockwave-flash">
  <param name="movie" value="FlowPlayerLight.swf" />
  <param name="flashvars" value="config={videoFile: 'foo'}" />
</object>

HERE;
$t->is($expected, flash_movie_player('foo'), "HTML object tag ok. Contains flowplayer");



$t->diag('flash_audio_player()');
$expected = <<<HERE
<object data="/xspf_player/xspf_player_slim.swf?player_title=Press+play+...&song_title=Space+door&song_url=foo"
        type="application/x-shockwave-flash" width="400" height="15">
  <param name="movie" 
         value="/xspf_player/xspf_player_slim.swf?player_title=Press+play+...&song_title=Space+door&song_url=foo" />
</object>    

HERE;
                              $t->is($expected, flash_audio_player('foo', 'Space+door'), "HTML object tag ok. Contains xspf_playerr");

