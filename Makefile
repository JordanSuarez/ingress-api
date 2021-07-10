#!/bin/bash

DOCKER_API=ingress-api
UID=$(shell id -u)

run: ## Start the containers
	U_ID=${UID} docker-compose up -d

stop: ## Stop the containers
	U_ID=${UID} docker-compose stop

restart: ## Restart the containers
	$(MAKE) stop && $(MAKE) run

build: ## Rebuilds all the containers
	U_ID=${UID} docker-compose build

connect: ## Installs composer dependencies
	docker exec -w /var/www/project -it ${DOCKER_API} bash
