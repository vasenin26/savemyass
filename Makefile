build:
	docker compose build
	make run
	docker compose exec httpd composer install

run:
	docker compose up -d

down:
	docker compose down

test:
	docker compose run --rm vendor/bin/phpunit

bash:
	docker compose exec httpd sh