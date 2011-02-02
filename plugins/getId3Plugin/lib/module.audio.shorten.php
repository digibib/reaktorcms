<?php
// +----------------------------------------------------------------------+
// | PHP version 5                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 2002-2004 James Heinrich                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2 of the GPL license,         |
// | that is bundled with this package in the file license.txt and is     |
// | available through the world-wide-web at the following url:           |
// | http://www.gnu.org/copyleft/gpl.html                                 |
// +----------------------------------------------------------------------+
// | getID3() - http://getid3.sourceforge.net or http://www.getid3.org    |
// +----------------------------------------------------------------------+
// | Authors: James Heinrich <infoØgetid3*org>                            |
// |          Allan Hansen <ahØartemis*dk>                                |
// +----------------------------------------------------------------------+
// | module.audio.shorten.php                                             |
// | Module for analyzing Shorten Audio files                             |
// | dependencies: module.audio-video.riff.php                            |
// +----------------------------------------------------------------------+
//
// $Id: module.audio.shorten.php,v 1.2 2006/06/13 08:44:50 ah Exp $

        
        
class getid3_shorten extends getid3_handler
{

    public function Analyze() {
        
        $getid3 = $this->getid3;
        
        $getid3->include_module('audio-video.riff');

        fseek($getid3->fp, $getid3->info['avdataoffset'], SEEK_SET);

        $shn_header = fread($getid3->fp, 8);
        
        // Magic bytes: "ajkg"
        
        $getid3->info['fileformat']            = 'shn';
        $getid3->info['audio']['dataformat']   = 'shn';
        $getid3->info['audio']['lossless']     = true;
        $getid3->info['audio']['bitrate_mode'] = 'vbr';

        $getid3->info['shn']['version'] = getid3_lib::LittleEndian2Int($shn_header{4});

        fseek($getid3->fp, $getid3->info['avdataend'] - 12, SEEK_SET);
        
        $seek_table_signature_test = fread($getid3->fp, 12);
        
        $getid3->info['shn']['seektable']['present'] = (bool)(substr($seek_table_signature_test, 4, 8) == 'SHNAMPSK');
        if ($getid3->info['shn']['seektable']['present']) {
        
            $getid3->info['shn']['seektable']['length'] = getid3_lib::LittleEndian2Int(substr($seek_table_signature_test, 0, 4));
            $getid3->info['shn']['seektable']['offset'] = $getid3->info['avdataend'] - $getid3->info['shn']['seektable']['length'];
            fseek($getid3->fp, $getid3->info['shn']['seektable']['offset'], SEEK_SET);
            $seek_table_magic = fread($getid3->fp, 4);
        
            if ($seek_table_magic != 'SEEK') {

                throw new getid3_exception('Expecting "SEEK" at offset '.$getid3->info['shn']['seektable']['offset'].', found "'.$seek_table_magic.'"');

            } else {

                // typedef struct tag_TSeekEntry
                // {
                //   unsigned long SampleNumber;
                //   unsigned long SHNFileByteOffset;
                //   unsigned long SHNLastBufferReadPosition;
                //   unsigned short SHNByteGet;
                //   unsigned short SHNBufferOffset;
                //   unsigned short SHNFileBitOffset;
                //   unsigned long SHNGBuffer;
                //   unsigned short SHNBitShift;
                //   long CBuf0[3];
                //   long CBuf1[3];
                //   long Offset0[4];
                //   long Offset1[4];
                // }TSeekEntry;

                $seek_table_data = fread($getid3->fp, $getid3->info['shn']['seektable']['length'] - 16);
                $getid3->info['shn']['seektable']['entry_count'] = floor(strlen($seek_table_data) / 80);

                //$getid3->info['shn']['seektable']['entries'] = array ();
                //$SeekTableOffset = 0;
                //for ($i = 0; $i < $getid3->info['shn']['seektable']['entry_count']; $i++) {
                //    $SeekTableEntry['sample_number'] = getid3_lib::LittleEndian2Int(substr($seek_table_data, $SeekTableOffset, 4));
                //    $SeekTableOffset += 4;
                //    $SeekTableEntry['shn_file_byte_offset'] = getid3_lib::LittleEndian2Int(substr($seek_table_data, $SeekTableOffset, 4));
                //    $SeekTableOffset += 4;
                //    $SeekTableEntry['shn_last_buffer_read_position'] = getid3_lib::LittleEndian2Int(substr($seek_table_data, $SeekTableOffset, 4));
                //    $SeekTableOffset += 4;
                //    $SeekTableEntry['shn_byte_get'] = getid3_lib::LittleEndian2Int(substr($seek_table_data, $SeekTableOffset, 2));
                //    $SeekTableOffset += 2;
                //    $SeekTableEntry['shn_buffer_offset'] = getid3_lib::LittleEndian2Int(substr($seek_table_data, $SeekTableOffset, 2));
                //    $SeekTableOffset += 2;
                //    $SeekTableEntry['shn_file_bit_offset'] = getid3_lib::LittleEndian2Int(substr($seek_table_data, $SeekTableOffset, 2));
                //    $SeekTableOffset += 2;
                //    $SeekTableEntry['shn_gbuffer'] = getid3_lib::LittleEndian2Int(substr($seek_table_data, $SeekTableOffset, 4));
                //    $SeekTableOffset += 4;
                //    $SeekTableEntry['shn_bit_shift'] = getid3_lib::LittleEndian2Int(substr($seek_table_data, $SeekTableOffset, 2));
                //    $SeekTableOffset += 2;
                //    for ($j = 0; $j < 3; $j++) {
                //        $SeekTableEntry['cbuf0'][$j] = getid3_lib::LittleEndian2Int(substr($seek_table_data, $SeekTableOffset, 4));
                //        $SeekTableOffset += 4;
                //    }
                //    for ($j = 0; $j < 3; $j++) {
                //        $SeekTableEntry['cbuf1'][$j] = getid3_lib::LittleEndian2Int(substr($seek_table_data, $SeekTableOffset, 4));
                //        $SeekTableOffset += 4;
                //    }
                //    for ($j = 0; $j < 4; $j++) {
                //        $SeekTableEntry['offset0'][$j] = getid3_lib::LittleEndian2Int(substr($seek_table_data, $SeekTableOffset, 4));
                //        $SeekTableOffset += 4;
                //    }
                //    for ($j = 0; $j < 4; $j++) {
                //        $SeekTableEntry['offset1'][$j] = getid3_lib::LittleEndian2Int(substr($seek_table_data, $SeekTableOffset, 4));
                //        $SeekTableOffset += 4;
                //    }
                //
                //    $getid3->info['shn']['seektable']['entries'][] = $SeekTableEntry;
                //}

            }

        }

        if ((bool)ini_get('safe_mode')) {
            throw new getid3_exception('PHP running in Safe Mode - backtick operator not available, cannot run shntool to analyze Shorten files');
        }


        // Running windows
        if ($getid3->windowed) {

            foreach (array ('shorten' => 'shorten.exe', 'cygwin' => 'cygwin1.dll', 'head' => 'head.exe') as $name => $req_filename) {
                
                $$name = $getid3->option_helperapps_dir.'\\'.$req_filename;
                
                if (!is_readable($$name)) {
                    throw new getid3_exception($$name.' does not exist.');
                }
            }
            
            $commandline = $shorten.' -x "'.realpath($getid3->filename).'" - | '.$head.' -c 44';
        } 
    
        // Running UNIX
        else {

            static $shorten_exe;
            if (!isset($shorten_exe)) {
                
                // which returns only executeable
                if ($shorten_exe = trim(`which shorten`)) {
                    // great    
                }
                elseif (is_executable('/usr/local/bin/shorten')) {
                    $shorten_exe = '/usr/local/bin/shorten';
                }
                elseif (is_executable('/usr/bin/shorten')) {
                    $shorten_exe = '/usr/bin/shorten';
                }
            }
                
            if (!$shorten_exe) {
                throw new getid3_exception('shorten binary was not found in path or /usr/local/bin or /usr/bin');
            }
            
            $commandline = $shorten_exe . ' -x '.escapeshellarg(realpath($getid3->filename)).' - | head -c 44';
        }

        $output = `$commandline`;

        if (@$output && substr($output, 12, 4) == 'fmt ') {

            $decoded_wav_format_ex = getid3_riff::RIFFparseWAVEFORMATex(substr($output, 20, 16));
            
            $getid3->info['audio']['channels']        = $decoded_wav_format_ex['channels'];
            $getid3->info['audio']['bits_per_sample'] = $decoded_wav_format_ex['bits_per_sample'];
            $getid3->info['audio']['sample_rate']     = $decoded_wav_format_ex['sample_rate'];

            if (substr($output, 36, 4) == 'data') {

                $getid3->info['playtime_seconds'] = getid3_lib::LittleEndian2Int(substr($output, 40, 4)) / $decoded_wav_format_ex['raw']['nAvgBytesPerSec'];

            } else {

                throw new getid3_exception('shorten failed to decode DATA chunk to expected location, cannot determine playtime');
            }

            $getid3->info['audio']['bitrate'] = (($getid3->info['avdataend'] - $getid3->info['avdataoffset']) / $getid3->info['playtime_seconds']) * 8;

        } else {

            throw new getid3_exception('shorten failed to decode file to WAV for parsing');
            return false;
        }

        return true;
    }

}

?>