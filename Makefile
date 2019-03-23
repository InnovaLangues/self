init: deps assets database
init-ci: deps assets permissions

permissions:
	setfacl -R -m u:www-data:rwX app/cache app/logs app/data
	setfacl -dR -m u:www-data:rwX app/cache app/logs app/data

deps:
	composer self-update
	composer install --no-interaction --no-ansi --no-progress --prefer-dist --no-suggest

assets:
	app/console cache:clear --env=prod
	app/console assets:install --symlink -env=prod
	app/console fos:js-routing:dump
	app/console bazinga:js-translation:dump
	app/console assetic:dump --env=prod

database:
	app/console doctrine:database:create --if-not-exists --no-interaction
	app/console doctrine:schema:update --force
	app/console doctrine:migrations:version --add --all --no-interaction
	app/console self:fixtures:load
