#!/bin/bash
 
REALFILE=$3;
TEMPFILE=$REALFILE.temp.flv
THUMBFILE=$REALFILE.thumb.jpg

$1 -map_meta_data infile:outfile -i $2 -acodec mp3 -ab 192000 -ar 44100 $TEMPFILE && \
$4 -U $TEMPFILE && \
mv $TEMPFILE $REALFILE

VLENGTH=`/usr/bin/mplayer -identify $REALFILE -nojoystick -nolirc -nosound -vc dummy -vo null 2>&1| grep ID_LENGTH | sed -e "s/ID_LENGTH=//g"`
LENGTH=`echo $VLENGTH | sed -e 's/\.[0-9]*//g'`
VIDEOLENGTH=`echo $(( $LENGTH / 2))| sed -e 's/\.[0-9]*//g'`
OUTPATH=`echo $REALFILE | sed -e 's/\/[^\/]*$//'`
/usr/bin/mplayer -ss $VIDEOLENGTH -really-quiet -nojoystick -nolirc -nocache -nortc -noautosub -vf scale  -nosound -frames 1 -zoom -vo jpeg:outdir=$OUTPATH:quality=100 $REALFILE 2>&1
mv $OUTPATH/00000001.jpg $THUMBFILE

