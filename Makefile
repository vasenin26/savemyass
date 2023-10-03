build:
	docker compose build

up:
	docker compose up -d

down:
	docker compose down

bash:
	docker compose exec --user=local -it httpd sh

test:
	docker compose exec --user=local httpd vendor/bin/phpunit --testdox

csfix:
	docker compose exec --user=local httpd vendor/bin/php-cs-fixer fix public/
	docker compose exec --user=local httpd vendor/bin/php-cs-fixer fix tests/

coverage:
	docker compose exec --user=local -e XDEBUG_MODE=coverage httpd vendor/bin/phpunit --coverage-html coverage

mutate:
	docker compose exec --user=local httpd vendor/bin/infection --threads=max

clear:
	rm -fR ./coverage .phpunit.cache .php-cs-fixer.cache .phpunit.result.cache