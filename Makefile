DOCKER_COMPOSE := docker compose

.PHONY: up
up: ## up all containers
	@$(DOCKER_COMPOSE) up -d --force-recreate --remove-orphans

.PHONY: db-migrate
db-migrate: ## Применить миграции БД.
	@$(DOCKER_COMPOSE) exec php php ./bin/console doctrine:migrations:migrate -n --no-debug

