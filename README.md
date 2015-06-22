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
sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx web/upload/ app/cache app/logs app/sessions app/data/export app/data/exportPdf app/data/session
sudo setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx web/upload/ app/cache app/logs app/sessions app/data/export app/data/exportPdf app/data/session
```

### Create a new admin user :
``` bash
php app/console fos:user:create admin --super-admin
```

### Change password or role or something else :
``` bash
https://github.com/FriendsOfSymfony/FOSUserBundle/blob/master/Resources/doc/command_line_tools.md
```

# Basic update 
``` bash
git pull
php app/console cache:clear --env=prod --no-debug
```

### Download and install wkhtmltox tool  :
[download from sourceforce](http://downloads.sourceforge.net/project/wkhtmltopdf/0.12.2.1/wkhtmltox-0.12.2.1_linux-wheezy-i386.deb?r=http%3A%2F%2Fsourceforge.net%2Fprojects%2Fwkhtmltopdf%2Ffiles%2Farchive%2F0.12.1%2F&ts=1432210988&use_mirror=netcologne)
``` bash
sudo dpkg -i wkhtmltox-*_linux-wheezy-amd64.deb
```

### Quality code services
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/InnovaLangues/self/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/InnovaLangues/self/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/128adf45-d4c4-4397-be56-4e1a279f2a38/mini.png)](https://insight.sensiolabs.com/projects/128adf45-d4c4-4397-be56-4e1a279f2a38)
[![Codacy Badge](https://www.codacy.com/project/badge/8121c45e21754233afcace1e6a998b9c)](https://www.codacy.com/app/arnaudbey_2541/self)
[![Code Climate](https://codeclimate.com/github/InnovaLangues/self/badges/gpa.svg)](https://codeclimate.com/github/InnovaLangues/self)
