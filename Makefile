init: down build up api-composer-install
up:
	docker-compose -f docker-compose.yml up -d
down:
	docker-compose -f docker-compose.yml down -v --remove-orphans
restart: down up
docker-pull:
	docker-compose pull
build:
	docker-compose -f docker-compose.yml build --pull
api-composer-install:
	docker-compose -f docker-compose.yml run --rm php-cli composer install
api-composer-update:
	docker-compose -f docker-compose.yml run --rm php-cli composer update