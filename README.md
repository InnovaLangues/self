# Installation

``` bash
git clone https://github.com/InnovaLangues/self.git
cd self
sudo setfacl -dR -m u:www-data:rwx -m u:youruser:rwx app/cache app/logs
sudo setfacl -R -m u:www-data:rwx -m u:youruser:rwx app/cache app/logs
```

create a database & user and fill in the app/config/parameter.yml

``` bash
composer install
php app/console doctrine:schema:drop --force
php app/console doctrine:schema:update --force
php app/console doctrine:fixtures:load
php app/console assets:install --symlink
php app/console cache:clear --env=prod --no-debug

```

Create a new admin user :

``` bash
php app/console fos:user:create admin2 --super-admin

```

# Basic update 

``` bash
git pull
git checkout master
php app/console cache:clear --env=prod --no-debug
```