init: down build up composer-install
up:
	docker-compose --file docker-compose.yml up -d
down:
	docker-compose --file docker-compose.yml down -v --remove-orphans
restart:
	down up
composer-install:
	docker-compose --file docker-compose.yml run --rm php-cli composer install
build:
	docker-compose --file docker-compose.yml build

# TODO: create make command migrate, load fixture, generate-migration

