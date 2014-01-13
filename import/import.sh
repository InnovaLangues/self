#!/bin/bash

cd upload/media
find . -iname "*.mp3" -exec sox {} {}.ogg \;
rename "s/mp3.//g" *mp3.ogg
echo 'Done'
