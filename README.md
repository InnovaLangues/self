# ! This repository is depcrecated and won't be updated any more ! #



# Installation

The following documentation is for a Linux host.

### Clone the project
``` bash
git clone https://github.com/InnovaLangues/self.git
cd self
```

## Step 1 [With docker]

```
docker-compose up -d
cp app/config/parameters.yml.dist app/config/parameters.yml
docker-compose exec web make init
make permissions
```

## Step 1 [Without docker]

### Requirements

- http server
- php >= 7.1
- mysql/mariadb
- redis

### Configure the application

In parameters.yml, specify your database name and credentials.

``` bash
cp app/config/parameters.yml.dist app/config/parameters.yml
vi app/config/parameters.yml
```

### Initialize the project and set permissions (requires setfacl)

```bash
make init
make permissions
```

### Download and install wkhtmltox tool  :

Need at least the 0.12.1 release...
[download from official site](http://wkhtmltopdf.org/downloads.html)
``` bash
sudo dpkg -i wkhtmltox-*_linux-wheezy-amd64.deb
```

## Step 2 : Initial data
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

# Update

Commands to run before an update on a production environment :

``` bash
php app/console doctrine:migrations:migrate
php app/console self:fixtures:load
php app/console assets:install --symlink -env=prod
php app/console fos:js-routing:dump --env=prod
php app/console bazinga:js-translation:dump
php app/console assetic:dump --env=prod
php app/console cache:clear --env=prod --no-debug
```

Note : the official self instances of use Ansible for this : https://github.com/InnovaLangues/self-deploy
