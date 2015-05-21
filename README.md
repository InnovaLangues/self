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

### Execute this command to add wkhtmltox tool to PDF export :
``` bash
sudo dpkg -i wkhtmltox-0.12.1_linux-wheezy-amd64.deb
```


[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/InnovaLangues/self/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/InnovaLangues/self/?branch=master)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/128adf45-d4c4-4397-be56-4e1a279f2a38/mini.png)](https://insight.sensiolabs.com/projects/128adf45-d4c4-4397-be56-4e1a279f2a38)

[![Codacy Badge](https://www.codacy.com/project/badge/8121c45e21754233afcace1e6a998b9c)](https://www.codacy.com/app/arnaudbey_2541/self)