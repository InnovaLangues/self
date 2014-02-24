# Installation


``` bash
git clone https://github.com/InnovaLangues/self.git
cd self
mkdir web/upload/media
mkdir web/upload/import/
sudo setfacl -dR -m u:www-data:rwx -m u:youruser:rwx app/cache app/logs web/upload/media web/upload/import
sudo setfacl -R -m u:www-data:rwx -m u:youruser:rwx app/cache app/logs web/upload/media web/upload/import
```

create a database & user and fill in the app/config/parameters.yml
``` bash
cp app/config/parameters.dist.yml app/config/parameters.yml
vi app/config/parameters.yml
```

``` bash
composer install
php app/console doctrine:schema:drop --force
php app/console doctrine:schema:update --force
php app/console self:fixtures:load
php app/console assets:install --symlink
php app/console cache:clear --env=prod --no-debug
```

Create a new admin user :
``` bash
php app/console fos:user:create admin --super-admin
```

### conversion wav -> mp3
``` bash
cd web/upload/import/mp3..
find . -iname "*.wav" -exec sox {} {}.mp3 \;
rename "s/wav.//g" *wav.mp3
``` 

### se connecter en admin et aller vers /admin/csv-import
> attendre

### conversion mp3 -> ogg et flv -> webm
``` bash
cd web/upload/media/
find . -iname "*.mp3" -exec sox {} {}.ogg \;
rename "s/mp3.//g" *mp3.ogg
find . -iname "*.flv" -exec avconv -i {} {}.webm \; 
rename "s/flv.//g" *flv.webm
rm *.flv
```


# Basic update 

``` bash
git pull
php app/console cache:clear --env=prod --no-debug
```
