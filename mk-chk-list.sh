#!/bin/bash
rm $2
br='<br>'
while read -r line
do
	echo $line$br >> $2
done <$1
