#!/bin/sh

cd ..
sudo git fetch
sudo git rebase origin/master
sudo composer install
php app/console assets:install --symlink
php app/console assetic:dump
php app/console doctrine:database:drop --force
php app/console doctrine:database:create
php app/console doctrine:schema:create
php app/console self:fixtures:load
php app/console cache:clear --env=prod --no-debug
php app/console fos:user:create admin admin@dev-self.innovalangues.net admin --super-admin
echo "Deleting web/upload/media/*"
rm -rf web/upload/media/*
echo "Done"
echo "Deleting web/upload/import/mp3/*/"
rm -rf web/upload/import/mp3/*/
echo "Done"
