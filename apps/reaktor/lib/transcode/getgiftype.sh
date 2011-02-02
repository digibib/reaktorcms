#!/bin/bash
# File identification script
# 

WC="`type -p wc`"
IDENTIFY="`type -p identify`"

FILENAME="$1"
MIMETYPE="$2"
FILETYPE="unknown"



GIF_TEST="`echo \"$IDENTIFY \"$FILENAME\"  |grep \" GIF\"|$WC -l \"|/bin/bash`"




if [ $GIF_TEST != "0" ] &&  [ $GIF_TEST != "1" ]; then
FILETYPE="video"
fi

if [ $GIF_TEST == "1" ]; then
FILETYPE="image"
fi





echo $FILETYPE;

echo $FILETYPE > /tmp/gtype