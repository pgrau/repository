current-dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))

# 🔍 Test
.PHONY: test
test:
	docker exec -it repo-php composer test

coverage:
	docker exec -it repo-php composer coverage

analizer:
	docker exec -it repo-php composer analizer

phpstan:
	docker exec -it repo-php composer phpstan

phpcs:
	docker exec -it repo-php composer phpcs

fixer:
	docker exec -it repo-php composer fixer

pipeline:
	docker exec repo-php composer phpcs
	docker exec repo-php composer phpstan
	docker exec repo-php composer test

# 🐳 Docker Compose
.PHONY: start
start:
	docker-compose up --build -d --remove-orphans
	docker exec repo-php composer install --ignore-platform-reqs --no-ansi

.PHONY: down
down:
	docker-compose down
