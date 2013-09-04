``` bash
git clone https://github.com/InnovaLangues/self.git
cd self
sudo setfacl -dR -m u:www-data:rwx -m u:youruser:rwx app/cache app/logs
sudo setfacl -R -m u:www-data:rwx -m u:youruser:rwx app/cache app/logs
```

create a database & user

``` bash
php app/console doctrine:fixtures:load
```