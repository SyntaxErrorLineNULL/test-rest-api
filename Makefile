init: down build up composer-install
up:
	docker-compose -f docker-compose.yml up -d
down:
	docker-compose -f docker-compose.yml down -v --remove-orphans
composer-install:
	docker-compose -f docker-compose.yml run --rm php-cli composer install
build:
	docker-compose -f docker-compose.yml build
install-db:
	docker-compose -f docker-compose.yml run --rm php-cli php bin/console.php install-db

# TODO: create make command migrate, load fixture, generate-migration