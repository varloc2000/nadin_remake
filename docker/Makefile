.PHONY: start stop init build tests

start:
	docker-compose up -d

stop:
	docker-compose stop

init:
	docker-compose build
	docker-compose up -d
	docker-compose exec php composer install
	docker-compose exec php php bin/console doctrine:database:create
	docker-compose exec php php bin/console doctrine:schema:create
	docker-compose exec php php bin/console doctrine:migrations:migrate --no-interaction
	docker-compose exec php php bin/console doctrine:fixtures:load --no-interaction
	docker-compose exec php php bin/console cache:clear
	docker-compose exec php php bin/console assets:install

tests:
	docker-compose exec php php vendor/bin/simple-phpunit
