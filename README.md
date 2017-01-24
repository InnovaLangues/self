# Requirements
php >= 5.4

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
php app/console doctrine:schema:update --force (or php app/console doctrine:migrations:migrate)
php app/console self:fixtures:load
php app/console assets:install --symlink -env=prod
php app/console fos:js-routing:dump
php app/console bazinga:js-translation:dump
php app/console assetic:dump --env=prod
php app/console cache:clear --no-debug --env=prod
```

### Create needed dirs and Set up rights
``` bash
sudo mkdir -p web/upload/ app/data/export app/data/exportPdf app/data/session app/data/importCsv app/data/user
sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx web/upload/ app/cache app/logs app/data/
sudo setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx web/upload/ app/cache app/logs app/data/
```

### Download and install wkhtmltox tool  :
Need at least the 0.12.1 release...
[download from official site](http://wkhtmltopdf.org/downloads.html)
``` bash
sudo dpkg -i wkhtmltox-*_linux-wheezy-amd64.deb
```

### Users :
Create an user
``` bash
php app/console fos:user:create username
```
Give some rights to user
``` bash
php app/console self:rightGroup:toggle username rightgroupname
```
See online users
``` bash
php app/console self:sessions:check
```

# Basic update
``` bash
php app/console lexik:maintenance:lock -n
git fetch
git checkout ...
php app/console doctrine:schema:update --force (or php app/console doctrine:migrations:migrate)
php app/console self:fixtures:load
php app/console assets:install --symlink -env=prod
php app/console fos:js-routing:dump --env=prod
php app/console bazinga:js-translation:dump
php app/console assetic:dump --env=prod
php app/console cache:clear --env=prod --no-debug
php app/console lexik:maintenance:unlock -n
```

### Quality code services
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/InnovaLangues/self/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/InnovaLangues/self/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/128adf45-d4c4-4397-be56-4e1a279f2a38/mini.png)](https://insight.sensiolabs.com/projects/128adf45-d4c4-4397-be56-4e1a279f2a38)
[![Codacy Badge](https://www.codacy.com/project/badge/8121c45e21754233afcace1e6a998b9c)](https://www.codacy.com/app/arnaudbey_2541/self)
[![Code Climate](https://codeclimate.com/github/InnovaLangues/self/badges/gpa.svg)](https://codeclimate.com/github/InnovaLangues/self)
