init: down up composer-install build-api init-db
up:
	docker-compose -f docker-compose.yml up -d
down:
	docker-compose -f docker-compose.yml down -v --remove-orphans
composer-install:
	docker-compose -f docker-compose.yml run --rm php-cli composer install
build-api:
	docker-compose -f docker-compose.yml build
init-db:
	docker-compose -f docker-compose.yml run --rm php-cli vendor/bin/doctrine orm:schema-tool:drop --force && \
	docker-compose -f docker-compose.yml run --rm php-cli vendor/bin/doctrine orm:schema-tool:create