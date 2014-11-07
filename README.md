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
php app/console assetic:dump --env=prod
php app/console assets:install --symlink -env=prod
php app/console cache:clear --no-debug --env=prod
```

### Create needed dirs and Set up rights 
``` bash
mkdir -p web/upload
sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx web/upload/ app/cache app/logs app/sessions app/data/export app/data/exportPdf
sudo setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx web/upload/ app/cache app/logs app/sessions app/data/export app/data/exportPdf
```

### Create a new admin user :
``` bash
php app/console fos:user:create admin --super-admin
```

### Change password or role or something else :
``` bash
https://github.com/FriendsOfSymfony/FOSUserBundle/blob/master/Resources/doc/command_line_tools.md
```

### Convert wav -> mp3 if needed
``` bash
find . -iname "*.wav" -exec sox {} {}.mp3 \;
rename "s/wav\.//g" *wav.mp3
``` 

### Convert mp3 -> ogg and flv -> webm
``` bash
cd web/upload/media/
find . -iname "*.mp3" -exec sox {} {}.ogg \;
rename "s/mp3\.//g" *mp3.ogg
find . -iname "*.flv" -exec avconv -i {} {}.webm \; 
rename "s/flv\.//g" *flv.webm
rm *.flv
```

# Basic update 

``` bash
git pull
php app/console cache:clear --env=prod --no-debug
```

### Execute this command to add wkhtmltox tool to PDF export :
``` bash
sudo dpkg -i wkhtmltox-0.12.1_linux-wheezy-amd64.deb
```
