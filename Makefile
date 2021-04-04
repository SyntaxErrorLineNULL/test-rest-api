init: down up composer-install
up:
	docker-compose -f docker-compose.yml up -d
down:
	docker-compose -f docker-compose.yml down -v --remove-orphans
composer-install:
	docker-compose -f docker-compose.yml run --rm php-cli composer install