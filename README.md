``` bash
git clone https://github.com/InnovaLangues/self.git
cd self
sudo setfacl -dR -m u:www-data:rwx -m u:youruser:rwx app/cache app/logs
sudo setfacl -R -m u:www-data:rwx -m u:youruser:rwx app/cache app/logs
```

create a database & user and fill in the app/config/parameter.yml

``` bash
php app/console doctrine:schema:drop --force
php app/console doctrine:schema:update --force
php app/console doctrine:fixtures:load
php app/console assets:install --symlink

```