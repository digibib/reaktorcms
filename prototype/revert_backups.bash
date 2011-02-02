#!/bin/bash
# This file will revert all the backups made to symfony created by the import script

if [ -z $1 ]
then
	echo "Usage $0 /path/to/symfony"
	exit
fi

cd $1
if [ -d content.bak ]
then
	echo "Reverting content directory"
	if [ -d content ]; then mv content content.imp; fi
	mv content.bak content
fi

cd config

declare -a files
files=(databases.yml propel.ini)

for file in ${files[@]}
do
	if [ -f $file.bak ]
	then
		echo "Reverting $file"
		if [ -f $file ]; then rm -rf $file; fi
		mv $file.bak $file
	fi
done

