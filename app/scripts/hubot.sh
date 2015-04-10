#!/usr/bin/env bash
TEXT='{"text":"'$1'"}'
ROOMID=$2
HUBOTTOKEN=$3
curl -X POST -i -H "Content-Type: application/json" -H "Accept: application/json" -H "Authorization: Bearer ${HUBOTTOKEN}" "https://api.gitter.im/v1/rooms/${ROOMID}/chatMessages" -d "${TEXT}"
