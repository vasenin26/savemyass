build:
	docker compose build

up:
	docker compose up -d

down:
	docker compose down

bash:
	docker compose exec -it httpd sh

coverage:
	docker compose exec -e XDEBUG_MODE=coverage httpd vendor/bin/phpunit --coverage-text