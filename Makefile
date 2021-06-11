#/**
# * This file was generated with TangoMan Makefile Generator
# * https://github.com/TangoMan75/makefile-generator
# *
# * Shaarli Netscape Bookmark Parser
# *
# * This library provides a decoder that is able of parsing Netscape bookmarks (as exported by common Web browsers and bookmarking services), and an encoder that is able to export data to bookmarks format.
# *
# * @version  4.0.0
# * @license  MIT
# * @link     https://github.com/shaarli/netscape-bookmark-parser
# */

.PHONY: help install tests coverage lint lint-fix

#--------------------------------------------------
# Colors
#--------------------------------------------------

PRIMARY   = \033[97m
SECONDARY = \033[36m
SUCCESS   = \033[32m
DANGER    = \033[31m
WARNING   = \033[33m
INFO      = \033[95m
LIGHT     = \033[47;90m
DARK      = \033[40;37m
DEFAULT   = \033[0m
NL        = \033[0m\n

#--------------------------------------------------
# Help
#--------------------------------------------------

## Print this help
help:
	@printf "${LIGHT} Shaarli Netscape Bookmark Parser ${NL}\n"

	@printf "${WARNING}Description${NL}"
	@printf "${PRIMARY}  This library provides a decoder that is able of parsing Netscape bookmarks (as exported by common Web browsers and bookmarking services), and an encoder that is able to export data to bookmarks format.${NL}\n"

	@printf "${WARNING}Usage${NL}"
	@printf "${PRIMARY}  make [command] `awk -F '?' '/^[ \t]+?[a-zA-Z0-9_-]+[ \t]+?\?=/{gsub(/[ \t]+/,"");printf"%s=[%s]\n",$$1,$$1}' ${MAKEFILE_LIST}|sort|uniq|tr '\n' ' '`${NL}\n"

	@printf "${WARNING}Commands${NL}"
	@awk '/^### /{printf"\n${PRIMARY}%s${NL}",substr($$0,5)} \
	/^[a-zA-Z0-9_-]+:/{HELP="";if( match(PREV,/^## /))HELP=substr(PREV, 4); \
		printf "${SUCCESS}  %-8s  ${PRIMARY}%s${NL}",substr($$1,0,index($$1,":")-1),HELP \
	}{PREV=$$0}' ${MAKEFILE_LIST}

## Install
install:
	@printf "${INFO}composer install --no-interaction --prefer-dist --optimize-autoloader${NL}"
	@composer install --no-interaction --prefer-dist --optimize-autoloader

## Run unit tests
tests:
	@printf "${INFO}./vendor/bin/phpunit tests/Unit --stop-on-failure${NL}"
	@./vendor/bin/phpunit tests/Unit --stop-on-failure

## Output test coverage
coverage:
	@printf "${INFO}XDEBUG_MODE=coverage ./vendor/bin/phpunit --coverage-html ./coverage${NL}"
	@XDEBUG_MODE=coverage ./vendor/bin/phpunit --coverage-html ./coverage

## Run linter
lint:
	@printf "${INFO}./vendor/bin/phpcs${NL}"
	@./vendor/bin/phpcs

## Lint source with phpcs linter
lint-fix:
	@printf "${INFO}./vendor/bin/phpcbf${NL}"
	@./vendor/bin/phpcbf
