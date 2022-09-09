# —— Inspired by ———————————————————————————————————————————————————————————————
# http://fabien.potencier.org/symfony4-best-practices.html
# https://speakerdeck.com/mykiwi/outils-pour-ameliorer-la-vie-des-developpeurs-symfony?slide=47
# https://blog.theodo.fr/2018/05/why-you-need-a-makefile-on-your-project/
# Setup ————————————————————————————————————————————————————————————————————————

# Parameters
SHELL         = sh
PROJECT       = restaurantly
HTTP_PORT     = 8000

# Executables
EXEC_PHP      = php
COMPOSER      = composer
REDIS         = redis-cli
GIT           = git
YARN          = yarn
NPM           = npm
NPX           = npx

# Alias
SYMFONY           = $(EXEC_PHP) bin/console
SYMFONY_CLI       = symfony
# if you use Docker you can replace with: "docker-compose exec my_php_container $(EXEC_PHP) bin/console"

# Executables: vendors
PHPUNIT       			= ./vendor/bin/phpunit
PHPSTAN       			= ./vendor/bin/phpstan
PHP_CS_FIXER  			= ./vendor/bin/php-cs-fixer
PHP_CODE_SNIFFER  		= ./vendor/bin/phpcs
PHP_CODE_SNIFFER_FIXER  = ./vendor/bin/phpcbf
PHPMD  					= ./vendor/bin/phpmd

# Executables: local only
SYMFONY_BIN   = symfony

# Misc
.DEFAULT_GOAL = help
.PHONY        : # Not needed here, but you can put your all your targets to be sure
                # there is no name conflict between your files and your targets.

## —— 🐝 The Rafdev Symfony Makefile 🐝 ———————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## —— Composer 🧙‍♂️ ————————————————————————————————————————————————————————————
install: composer.lock ## Install vendors according to the current composer.lock file
	@$(COMPOSER) install --no-progress --prefer-dist --optimize-autoloader

## —— Symfony 🎵 ———————————————————————————————————————————————————————————————
sf: ## List all Symfony commands
	@$(SYMFONY)

cc: ## Clear the cache. DID YOU CLEAR YOUR CACHE????
	@$(eval env ?= 'dev')
	@$(SYMFONY) c:c --env=$(env)
	@$(SYMFONY) c:w --env=$(env)

warmup: ## Warmup the cache
	@$(eval env ?= 'dev')
	@$(SYMFONY) cache:warmup --env=$(env)

fix-perms: ## Fix permissions of all var files
	@chmod -R 777 var/*

assets: purge ## Install the assets with symlinks in the public folder
	@$(SYMFONY) assets:install public/  # Don't use "--symlink --relative" with a Docker env

purge: ## Purge cache and logs
	@rm -rf var/cache/* var/logs/*

## —— Symfony binary 💻 ————————————————————————————————————————————————————————
cert-install: ## Install the local HTTPS certificates
	@$(SYMFONY_BIN) server:ca:install

serve: ## Serve the application with HTTPS support (add "--no-tls" to disable https)
	@$(SYMFONY_BIN) serve --daemon --port=$(HTTP_PORT) ## --no-tls

unserve: ## Stop the webserver
	@$(SYMFONY_BIN) server:stop

## —— Project 🐝 ———————————————————————————————————————————————————————————————
#start: up wait-for-mysql load-fixtures wait-for-elasticsearch populate serve ## Start docker, load fixtures, populate the Elasticsearch index and start the webserver
start: serve ## Start docker, load fixtures, populate the Elasticsearch index and start the webserver

reload: load-fixtures ## Load fixtures

stop: unserve ## Stop docker and the Symfony binary server

cc-redis: ## Flush all Redis cache
	@$(REDIS) -p 6389 flushall

commands: ## Display all commands in the project namespace
	@$(SYMFONY) list $(PROJECT)

exec-migrations: ## Execute all migrations
	@$(SYMFONY) doctrine:migrations:migrate --no-interaction

load-fixtures: ## Build the DB, control the schema validity, load fixtures and check the migration status
	make exec-migrations
	make clear-uploads-files
	@$(SYMFONY) doctrine:fixtures:load --no-interaction

init-snippet: ## Initialize a new snippet
	@$(SYMFONY) $(PROJECT):init-snippet

database-dev: ## Initialize the dev database
	@$(SYMFONY) doctrine:database:drop --if-exists --force
	@$(SYMFONY) doctrine:database:create

database-test: ## Initialize the test database
	@$(SYMFONY) doctrine:database:drop --force --env=test
	@$(SYMFONY) doctrine:database:create --env=test
	@$(SYMFONY) doctrine:schema:update --force --env=test

clear-uploads-files: ## Delete all upload files
	find public/uploads/ -type f \( -iname '*.jpg' -o -iname '*.png' -o -iname '*.gif' -o -iname '*.pdf' \) -delete

## —— Tests ✅ —————————————————————————————————————————————————————————————————
test: phpunit.xml ## Run tests with optional suite and filter
	@$(eval testsuite ?= 'all')
	@$(eval filter ?= '.')
	@$(PHPUNIT) --testsuite=$(testsuite) --filter=$(filter) --stop-on-failure

test-all: phpunit.xml ## Run all tests
	@$(PHPUNIT) --stop-on-failure

## —— Coding standards ✨ ——————————————————————————————————————————————————————
cs: lint-php lint-js ## Run all coding standards checks

static-analysis: stan ## Run the static analysis (PHPStan)

stan: ## Run PHPStan
	@$(PHPSTAN) analyse -c phpstan.neon --memory-limit 1G

lint-php: ## Lint files with php-cs-fixer
	@$(PHP_CS_FIXER) fix --allow-risky=yes --dry-run

fix-php: ## Fix files with php-cs-fixer
	@$(PHP_CS_FIXER) fix --allow-risky=yes

phpmd: ## Run php Mess Detector
	@$(PHPMD) src,tests xml /phpmd.xml.dist

sniffer-php: ## Sniff php files with php-cs
	@$(PHP_CODE_SNIFFER)

sniffer-fix-php: ## Fix php files with php-cs
	@$(PHP_CODE_SNIFFER_FIXER)

analysis: sniffer-fix-php fix-php phpmd stan ## Run code analysis

lint: ## Run code analysis and lint
	@$(SYMFONY)  		lint:yaml config --parse-tags
	@$(SYMFONY)	 		lint:twig templates --env=prod
	@$(SYMFONY)  		lint:container
	@$(SYMFONY)	  		doctrine:schema:validate --skip-sync -vvv --no-interaction
	@$(COMPOSER) 	 	validate --strict
	@$(SYMFONY_CLI)  	check:security

## —— Yarn / Npm 🐱 / JavaScript —————————————————————————————————————————————————————
dev: ## Rebuild assets for the dev env
	@$(NPM) install --check-files
	@$(NPM) run encore dev

dev-server: ## Rebuild assets for the dev env
	@$(NPM) install --check-files
	@$(NPM) run encore dev-server

watch: ## Watch files and build assets when needed for the dev env
	@$(NPM) run encore dev --watch

encore: ## Build assets for production
	@$(NPM) run encore production

lint-js: ## Lints JS coding standards
	@$(NPX) eslint assets/js

fix-js: ## Fixes JS files
	@$(NPX) eslint assets/js --fix
