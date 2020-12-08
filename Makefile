connect-php: ## Connect php
	docker-compose exec php-fpm bash

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

cli:
	docker-compose run --rm php-cli

symfony-console:
	docker-compose run --rm php-cli php bin/console
