connect-php: ## Connect php
	docker-compose exec php-fpm bash

init-dev: env-dev docker-pull docker-build docker-up app-init ## Initialize project

docker-build:
	docker-compose build

docker-pull:
	docker-compose pull

docker-up:
	docker-compose up -d

app-init: ## Deploy last version
	docker-compose run --rm php-cli composer install
	docker-compose run --rm php-cli bin/console d:m:m -e dev --no-interaction

env-dev:
	cp -n .env.dist .env

run-tests: ## Start tests
	docker-compose run --rm php-cli bin/phpunit

docker-down: ## Stop container
	docker-compose down --remove-orphans