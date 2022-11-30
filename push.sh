#!/usr/bin/bash
DATE=`date '+%Y-%m-%d'`
#echo "$DATE" 177Wl2477
php command test/delete-ds-store
git commit -a -m "$DATE"
git push