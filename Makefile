init: down up composer-install build-api
up:
	docker-compose -f docker-compose.yml up -d
down:
	docker-compose -f docker-compose.yml down -v --remove-orphans
composer-install:
	docker-compose -f docker-compose.yml run --rm php-cli composer install
build-api:
	docker-compose -f docker-compose.yml build