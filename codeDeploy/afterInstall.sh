#!/usr/bin/env bash

aws s3 cp s3://exposuresoftware-configs/eternaltools.env /usr/share/nginx/eternaltools/.env
cd /usr/share/nginx/eternaltools || exit 1
su www-data -s /bin/bash -c "php artisan migrate --force"
aws s3 cp s3://exposuresoftware-configs/eternaltools.conf /etc/nginx/sites-enabled/eternaltools.conf
service nginx restart
