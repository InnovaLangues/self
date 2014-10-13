for f in ../../web/upload/media/*.mp3; 
do  
    if [ ! -f "$f.ogg" ]
    then
         echo "Converting $(basename $f)"; 
         sudo sox $f $f.ogg;
         echo "Changing owner and group for $(basename $f)"; 
         sudo chown www-data $f.ogg;
         sudo chgrp www-data $f.ogg;
         echo "$(basename $f) processed.\n"; 
    fi
done
