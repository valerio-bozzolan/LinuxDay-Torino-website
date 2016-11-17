#! /bin/bash

FILES=`ls $1`

size=${#FILES}

if [ "$size" = "0" ]; then
   echo "Nessun file in questa directory"
else
    echo "I file in questa directory sono:"
    for f in $FILES;
    do
        echo $f
    done
fi
