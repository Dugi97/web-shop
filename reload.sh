#!/bin/bash

php bin/console doctrine:schema:update --force
php bin/console assets:install --symlink
php bin/console cache:clear

echo "all Done"
exit
