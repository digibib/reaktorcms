#!/bin/bash
# Mimetype identification script
# 
# Please remember to give write permission to apache user to its own home directory
# jus to avoid this message:  (gnomevfs-info:20527): libgnomevfs-WARNING **: Unable to create ~/.gnome2 directory: Permission denied
#
#

gfsinfocmd="`type -p gnomevfs-info`"
awkcmd="`type -p awk`"
grepcmd="`type -p grep`"
tailcmd="`type -p tail`"
filecmd="`type -p file`"


FILENAME="$1"
RES=`$gfsinfocmd -s  "$FILENAME" |$grepcmd "MIME type"| $tailcmd -c +21 2>/dev/null `


if [ $RES == "application/octet-stream" ]; then
RES=`$filecmd  -b -i  "$FILENAME"  2>/dev/null `

fi


echo $RES

