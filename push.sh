#!/usr/bin/bash
DATE=`date '+%Y-%m-%d'`
#echo "$DATE"
php command test/delete-ds-store
git commit -m "$DATE"
git push