#!/usr/bin/env bash

rm -rf /usr/share/nginx/eternaltools/storage/logs/*
rm -rf /usr/share/nginx/eternaltools/storage/framework/*

if [[ -e /usr/share/nginx/eternaltools/.env ]]; then
    rm /usr/share/nginx/eternaltools/.env
fi
