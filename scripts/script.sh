#!/usr/bin/env bash
# sed  -i "s/\${$1}/$2/g" /docker-entrypoint-initdb.d/init.sql

sed -i "s|\${$1}|$2|g" /docker-entrypoint-initdb.d/init.sql