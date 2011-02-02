#!/bin/bash
# Swap directories
#
# Author: Robert Strind <robert@linpro.no>
#
echo "Swoping content"

if [ -z $1 ]
then
        echo "Usage: $0 /path/to/symfony [swop_directory_name]"
        exit
fi

SWOP=$1content.bak
CONTENT=$1content
TMP=$1content.tmp

if [ $2 ]
then
        echo "Swopping $SWOP"
        SWOP=$1$2
fi

mv $CONTENT $TMP
mv $SWOP $CONTENT
mv $TMP $SWOP
echo "Swap complete"

