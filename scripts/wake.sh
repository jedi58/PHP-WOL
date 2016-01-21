#!/bin/bash
if [[ "$#" -ne 2 ]]; then
	echo "Missing arguments."
	echo "Syntax: ./scripts/wol.sh <broadcast-ip> <mac-address>"
else
	php -r "include 'src/Wol.php'; Wol::wake('$1', '$2');"
fi