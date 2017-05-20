#!/bin/bash

gunzip *.* 2> /dev/null

set `ls`

for i in $*; do
	if [[ $i == *.1 ]]; then
		(groff -t -e -mandoc -Tascii $i | col -bx > $i'.txt') 2> /dev/null
	fi
done
