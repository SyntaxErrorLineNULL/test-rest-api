init: down build up api-composer-install init-db
up:
	docker-compose -f docker-compose.yml up -d
down:
	docker-compose -f docker-compose.yml down -v --remove-orphans
restart: init
build:
	docker-compose -f docker-compose.yml build --pull
api-composer-install:
	docker-compose -f docker-compose.yml run --rm php-cli composer install
api-composer-update:
	docker-compose -f docker-compose.yml run --rm php-cli composer update
init-db:
	docker-compose -f docker-compose.yml run --rm php-cli vendor/bin/doctrine orm:schema-tool:drop --force && \
    docker-compose -f docker-compose.yml run --rm php-cli vendor/bin/doctrine orm:schema-tool:create