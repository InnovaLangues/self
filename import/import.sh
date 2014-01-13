#!/bin/bash

cd upload/media
find . -iname "a1cot13*.mp3" -exec sox {} {}.ogg \;
rename "s/mp3.//g" *mp3.ogg
echo 'Done'
