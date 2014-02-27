# Installation

### clone the project, create needed dir
``` bash
git clone https://github.com/InnovaLangues/self.git
cd self
```

### create a database & user and fill in the app/config/parameters.yml
``` bash
cp app/config/parameters.yml.dist app/config/parameters.yml
vi app/config/parameters.yml
```

### Download vendors, update schema and assets install
``` bash
composer update
php app/console doctrine:schema:drop --force
php app/console doctrine:schema:update --force
php app/console self:fixtures:load
php app/console assetic:dump
php app/console assetic:dump --env=prod
php app/console assets:install --symlink
php app/console assets:install --symlink -env=prod
php app/console cache:clear --no-debug
php app/console cache:clear --no-debug --env=prod
```

### Create needed dirs and Set up rights 
``` bash
mkdir web/upload/media
mkdir web/upload/import/
sudo setfacl -dR -m u:www-data:rwx -m u:youruser:rwx web/upload/media web/upload/import app/cache app/logs
sudo setfacl -R -m u:www-data:rwx -m u:youruser:rwx web/upload/media web/upload/import app/cache app/logs
```

### Create a new admin user :
``` bash
php app/console fos:user:create admin --super-admin
```

### Copy mp3 files and csv files into web/upload/import...

### Launch "moulinette" (check mp3 and csv dir in TestController before)

### Convert wav -> mp3
``` bash
cd web/upload/import/mp3..
find . -iname "*.wav" -exec sox {} {}.mp3 \;
rename "s/wav.//g" *wav.mp3
``` 

### Connect with admin user and go to /admin/csv-import
> wait :)

### Convert mp3 -> ogg and flv -> webm
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
