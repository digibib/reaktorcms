#!/bin/bash

REALFILE=$3;
TEMPFILE=$REALFILE.temp.mp3

$1 -map_meta_data infile:outfile -i $2 -acodec mp3 -ar 22050 $TEMPFILE
mv $TEMPFILE $REALFILE
