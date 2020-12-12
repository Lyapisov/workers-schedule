connect-php: ## Connect php
	docker-compose exec php-fpm bash

initialize-locally: ## Initialize project
	cp -n .env.dist .env
	docker-compose up -d
	make deploy-update

deploy-update: ## Deploy last version
	docker-compose up -d --remove-orphans --build
	docker-compose run --rm php-cli composer install
	docker-compose run --rm php-cli bin/console d:m:m -e dev --no-interaction

run-tests: ## Start tests
	docker-compose run --rm php-cli bin/phpunit

docker-build:
	docker-compose build

docker-up:
	docker-compose up -d

docker-build-up: ## Build container and start
	docker-compose up -d --build

docker-down: ## Stop container
	docker-compose down --remove-orphans

cli:
	docker-compose run --rm php-cli
