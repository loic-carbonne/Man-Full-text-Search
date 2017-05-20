#!/bin/bash

gunzip *.* 2> /dev/null

set `ls`

for i in $*; do
	if [[ $i == *.1 ]]; then
		(~/roffit-master/roffit $i > $i'.html') 2> /dev/null
	fi
done
