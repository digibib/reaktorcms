#!/bin/bash

REALFILE=$3;
TEMPFILE=$REALFILE.temp.wav
TOUCHED=$4.temp.mp3

touch $TOUCHED
$1 $3 -Ow -o $TEMPFILE 
rm $TOUCHED
$5 $2 $TEMPFILE $4 
rm $TEMPFILE
