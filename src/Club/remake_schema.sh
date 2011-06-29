#!/bin/bash

sudo rm -rf ../../app/cache/*
sudo chmod 777 ../../app/logs ../../app/cache

#php ../../bin/vendors install

php ../../app/console doctrine:database:drop --force
php ../../app/console doctrine:database:create
php ../../app/console doctrine:migrations:migrate --no-interaction
php ../../app/console doctrine:fixtures:load
php ../../app/console assets:install ../../web

sudo chmod 777 -R ../../app/logs ../../app/cache
sudo chown www-data:www-data ../../app/cache ../../app/logs
