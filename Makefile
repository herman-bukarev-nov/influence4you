default: help

# changeble variables
app                   ?= unnamed
env                   ?= local
app_host              ?= ${app}.${env}
port                  ?= 80

# constants
APP_NAME               = ${app}
APP_ENV                = ${env}
APP_ROOT_DIR           = /application
APP_SCHEMA             = http
APP_HOST               = ${app_host}
APP_URL                = ${APP_SCHEMA}://${app_host}
APP_UID                = $(shell id -u)
APP_GID                = $(shell id -g)

DB_HOST                = database
DB_CONNECTION          = pgsql
DB_PORT                = 5432
DB_SERVICE_TARGET      = postgres
DB_DATABASE            = ${APP_NAME}
DB_USERNAME            = ${APP_NAME}
DB_PASSWORD            = $(shell openssl rand -base64 16)
DB_TEST_PREFIX         = test_

COMPOSE_FILE           = docker/docker-compose.yml
COMPOSE_WEBSERVER_PORT = ${port}
COMPOSE_DATABASE_PORT  = 8020

# Helper to Catch no-interaction Mode from command line arguments
ifeq ($(shell echo ${MAKECMDGOALS} | grep -c "no-interaction\|nointeraction"),1)
	ASK=0
	INTERACTION_TARGET=no-interaction
else
	ASK=1
	INTERACTION_TARGET=
endif
no-interaction:
	@echo '' >/dev/null
nointeraction:
	@echo '' >/dev/null

# CLI COLORS
RED    := $(shell tput -Txterm setaf 1)
GREEN  := $(shell tput -Txterm setaf 2)
WHITE  := $(shell tput -Txterm setaf 7)
YELLOW := $(shell tput -Txterm setaf 3)
RESET  := $(shell tput -Txterm sgr0)


HELP_FUNC = \
    %help; \
    while(<>) { push @{$$help{$$2 // 'options'}}, [$$1, $$3] if /^([a-zA-Z\-]+)\s*:.*\#\#(?:@([a-zA-Z\-]+))?\s(.*)$$/ }; \
    print "usage: make [target]\n\n"; \
    for (sort keys %help) { \
    print "${WHITE}$$_:${RESET}\n"; \
    for (@{$$help{$$_}}) { \
    $$sep = " " x (32 - length $$_->[0]); \
    print "  ${YELLOW}$$_->[0]${RESET}$$sep${GREEN}$$_->[1]${RESET}\n"; \
    }; \
    print "\n"; }


GET_ENV_ARG = `grep ^$(1)= .env | cut -d '=' -f2`


help: ##@Util Show this help.
	@perl -e '$(HELP_FUNC)' $(MAKEFILE_LIST)


install: ##@Project First Time Install Project
	@make environment-create environment-install ${INTERACTION_TARGET}
	@make app-create app-install ${INTERACTION_TARGET}


uninstall:  ##@Project Clear file system and Remove Project
	@make environment-uninstall app-clear environment-clear ${INTERACTION_TARGET}


environment-create: ##@Environment Create Project Environment Configs
ifeq (${ASK}, 1)
	@( read -p "${RED}All Environment Config files will be overriden! Are you sure? [y/N] ${RESET}: " sure && case "$$sure" in [yY]) true;; *) false;; esac )
endif
	@echo "${YELLOW}Create Environment Configuration for ${GREEN}${APP_NAME}${YELLOW} Project ${RESET}"
	@make create-env-file
ifeq (${ASK}, 1)
ifeq (${APP_ENV}, local)
ifeq ($(shell cat /etc/hosts | grep -c "rules for ${APP_NAME} project"), 0)
	@echo "${YELLOW}Administrator Password is Needed For Write Host to ${GREEN}/etc/hosts${RESET}"
	@sudo sh -c "echo '# rules for $(call GET_ENV_ARG,APP_NAME) project' >> /etc/hosts"
	@sudo sh -c "echo '127.0.0.1 $(call GET_ENV_ARG,APP_HOST)' >> /etc/hosts"
endif
endif
endif


create-env-file:
	@sed " \
		s,APP_NAME=,APP_NAME=${APP_NAME},; \
		s,APP_ENV=,APP_ENV=${APP_ENV},; \
		s,APP_ROOT_DIR=,APP_ROOT_DIR=${APP_ROOT_DIR},; \
		s,APP_HOST=,APP_HOST=${APP_HOST},; \
		s,APP_SCHEMA=,APP_SCHEMA=${APP_SCHEMA},; \
		s,APP_URL=,APP_URL=${APP_URL},; \
		s,APP_UID=,APP_UID=${APP_UID},; \
		s,APP_GID=,APP_GID=${APP_GID},; \
		s,DB_CONNECTION=,DB_CONNECTION=${DB_CONNECTION},; \
		s,DB_HOST=,DB_HOST=${DB_HOST},; \
		s,DB_PORT=,DB_PORT=${DB_PORT},; \
		s,DB_DATABASE=,DB_DATABASE=${DB_DATABASE},; \
		s,DB_USERNAME=,DB_USERNAME=${DB_USERNAME},; \
		s,DB_PASSWORD=,DB_PASSWORD=${DB_PASSWORD},; \
		s,DB_TEST_PREFIX=,DB_TEST_PREFIX=${DB_TEST_PREFIX},; \
		s,COMPOSE_FILE=,COMPOSE_FILE=${COMPOSE_FILE},; \
		s,COMPOSE_WEBSERVER_PORT=,COMPOSE_WEBSERVER_PORT=${COMPOSE_WEBSERVER_PORT},; \
		s,COMPOSE_DATABASE_PORT=,COMPOSE_DATABASE_PORT=${COMPOSE_DATABASE_PORT},;" \
    	.env.dist > .env


environment-install: ##@Environment Build Docker Containers And Start Them
	@echo "${YELLOW}Build Docker Environment for ${GREEN}$(call GET_ENV_ARG,APP_NAME)${YELLOW} Project ${RESET}"
	@docker-compose up --build -d
	@docker-compose ps


environment-uninstall: ##@Environment Remove Docker Environment Containers
ifeq (${ASK}, 1)
	@( read -p "${RED}Do you want to remove Project Environment? [y/N] ${RESET}: " sure && case "$$sure" in [yY]) true;; *) false;; esac )
endif
	@docker-compose down
ifeq (${ASK}, 1)
	@echo "${YELLOW}Administrator Password is Needed to Remove Database Data${RESET}"
	@sudo rm -rf database/data
else
	@echo "${RED}You Must remove Database dirrectory [database/data] manualy!${RESET}"
endif


environment-clear: ##@Environment Remove Project Environment Configs
	@rm -f .env


app-create: ##@Application Install Dependent Vendors for Project Application
	@docker-compose exec -T cli composer install ${COMPOSER_DEV_KEY} --no-interaction --prefer-dist --optimize-autoloader
	@docker-compose exec -T cli artisan key:generate
	@docker-compose down
	@docker-compose up -d


app-install: ##@Application Setup Application
	@docker-compose exec -T cli artisan migrate:fresh --seed


app-clear: ##@Application Remove CSV Ignored Files of Project
ifeq (${ASK}, 1)
	@( read -p "${RED}Do you want to remove All CSV Ignored files of Project? [y/N] ${RESET}: " sure && case "$$sure" in [yY]) true;; *) false;; esac )
endif
	@rm -fr vendor/


cli: ##@Util Get Application Command Line Interface
	@docker-compose exec cli bash


.PHONY: purge nointeraction no-interaction cli install uninstall app-clear environment-clear
