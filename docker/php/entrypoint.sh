#!/bin/bash

SOURCE="/usr/src/cache/vendor/"
TARGET="/var/www/app/vendor/"

if [ ! -d "$TARGET" ]; then
  echo "Target directory does not exist, copying files..."
  cp -r "$SOURCE" "$TARGET"
  cd /var/www/app
  exec composer dumpautoload
  exec php bin/console cache:clear
else
  echo "Target directory already exists, skipping copy."
fi

rm -r /usr/src/cache/

exec php-fpm
