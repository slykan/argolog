#!/bin/bash
cd ~/agrolog
git pull origin main
npm run build
/opt/cpanel/ea-php83/root/usr/bin/php artisan config:cache
/opt/cpanel/ea-php83/root/usr/bin/php artisan route:cache
/opt/cpanel/ea-php83/root/usr/bin/php artisan view:cache
echo "Deploy gotov!"
