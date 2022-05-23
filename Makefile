#!make
include .env
export $(shell sed 's/=.*//' .env)

fresh: ## Fresh databases
	php artisan migrate:fresh --seed
	php artisan migrate:fresh --database=mysql_test

refresh: ## Refresh databases
	php artisan migrate:refresh --seed
	php artisan migrate:refresh --database=mysql_test

admin: ## Create Admin user
	php artisan db:seed --class=UsersTableSeeder

sdb: ## Seed DataBase
	php artisan db:seed --class=DatabaseSeeder

test: ## Run test suit
	./vendor/bin/phpcs
	./vendor/bin/phpstan --memory-limit=-1

cs: ## Run phpcs
	./vendor/bin/phpcs

csfix: ## Autofix phpcs errors
	./vendor/bin/phpcbf

stan: ## Run phpstan
	./vendor/bin/phpstan --memory-limit=-1

unit:
	./vendor/bin/phpunit
