#!/bin/bash
# File identification script
# 

MPLAYER="`type -p mplayer`"
WC="`type -p wc`"

FILENAME="$1"
FILETYPE="unknown"

AUDIO_PARAM=" -identify -vo null -ao null -frames 0 \"$FILENAME\" 2> /dev/null |grep ID_AUDIO_ID|$WC -l"
VIDEO_PARAM=" -identify -vo null -ao null -frames 0 \"$FILENAME\" 2> /dev/null |grep ID_VIDEO_ID|$WC -l"

AUDIO_TEST="`echo \"$MPLAYER $AUDIO_PARAM \"|/bin/bash`"
VIDEO_TEST="`echo \"$MPLAYER $VIDEO_PARAM \"|/bin/bash`"


if [ "$AUDIO_TEST" != "0" ]; then
	FILETYPE="audio"
fi


if [ "$VIDEO_TEST" != "0" ]; then
	FILETYPE="video"
fi

echo $FILETYPE;
