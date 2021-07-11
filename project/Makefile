#!/bin/bash

composer-install: ## Installs composer dependencies
	composer install --no-scripts --no-interaction --optimize-autoloader

migration: ## Runs the migrations
	php bin/console make:migration

migrate: ## migrate the migrations
	php bin/console doctrine:migrations:migrate

fixtures: ## Load the fixtures from missions.json
	php bin/console doctrine:fixtures:load

create-db: ## Create the database
	php bin/console doctrine:database:create