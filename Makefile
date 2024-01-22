IS_PHP82:=$(shell php -r 'echo (int)version_compare(PHP_VERSION, "8.2", ">=");')

default: build

build: install test
.PHONY: build

install:
	composer install
.PHONY: install

update:
	composer update
.PHONY: update

update-min:
	composer update --prefer-stable --prefer-lowest
.PHONY: update-min

update-no-dev:
	composer update --prefer-stable --no-dev
.PHONY: update-no-dev

test: vendor cs deptrac phpunit infection
.PHONY: test

test-min: update-min cs deptrac phpunit infection
.PHONY: test-min

ifeq ($(IS_PHP82),1)
test-package:
else
test-package: package test-package-tools
	cd tests/phar && ./tools/phpunit
endif
.PHONY: test-package

cs: tools/php-cs-fixer
	PHP_CS_FIXER_IGNORE_ENV=1 tools/php-cs-fixer --dry-run --allow-risky=yes --no-interaction --ansi fix
.PHONY: cs

cs-fix: tools/php-cs-fixer
	PHP_CS_FIXER_IGNORE_ENV=1 tools/php-cs-fixer --allow-risky=yes --no-interaction --ansi fix
.PHONY: cs-fix

deptrac: tools/deptrac
	tools/deptrac --no-interaction --ansi
.PHONY: deptrac

infection: tools/infection tools/infection.pubkey
	./tools/infection --no-interaction --formatter=progress --min-msi=100 --min-covered-msi=100 --ansi
.PHONY: infection

phpunit: tools/phpunit
	tools/phpunit
.PHONY: phpunit

phpunit-coverage: tools/phpunit
	phpdbg -qrr tools/phpunit
.PHONY: phpunit

tools: tools/php-cs-fixer tools/deptrac tools/infection tools/box
.PHONY: tools

test-package-tools: tests/phar/tools/phpunit tests/phar/tools/phpunit.d/zalas-phpunit-doubles-extension.phar
.PHONY: test-package-tools

clean:
	rm -rf build
	rm -rf vendor
	find tools -not -path '*/\.*' -type f -delete
	find tests/phar/tools -not -path '*/\.*' -type f -delete
.PHONY: clean

ifeq ($(IS_PHP82),1)
package:
else
package: tools/box
	$(eval VERSION=$(shell (git describe --abbrev=0 --tags 2>/dev/null || echo "0.1-dev") | sed -e 's/^v//'))
	@rm -rf build/phar && mkdir -p build/phar

	cp -r src LICENSE composer.json scoper.inc.php build/phar
	sed -e 's/@@version@@/$(VERSION)/g' manifest.xml.in > build/phar/manifest.xml

	cd build/phar && \
	  composer remove phpunit/phpunit --no-update && \
	  composer config platform.php 8.1 && \
	  composer update --no-dev -o -a

	tools/box compile

	@rm -rf build/phar
endif
.PHONY: package

vendor: install

vendor/bin/phpunit: install

tools/phpunit: vendor/bin/phpunit
	ln -sf ../vendor/bin/phpunit tools/phpunit

tools/php-cs-fixer:
	curl -Ls http://cs.symfony.com/download/php-cs-fixer-v3.phar -o tools/php-cs-fixer && chmod +x tools/php-cs-fixer

tools/deptrac:
	curl -Ls https://github.com/sensiolabs-de/deptrac/releases/download/1.0.2/deptrac.phar -o tools/deptrac && chmod +x tools/deptrac

tools/infection: tools/infection.pubkey
	curl -Ls https://github.com/infection/infection/releases/download/0.27.9/infection.phar -o tools/infection && chmod +x tools/infection

tools/infection.pubkey:
	curl -Ls https://github.com/infection/infection/releases/download/0.27.9/infection.phar.pubkey -o tools/infection.pubkey

tools/box:
	curl -Ls https://github.com/humbug/box/releases/download/3.16.0/box.phar -o tools/box && chmod +x tools/box

tests/phar/tools/phpunit:
	curl -Ls https://phar.phpunit.de/phpunit-9.phar -o tests/phar/tools/phpunit && chmod +x tests/phar/tools/phpunit

tests/phar/tools/phpunit.d/zalas-phpunit-doubles-extension.phar: build/zalas-phpunit-doubles-extension.phar
	cp build/zalas-phpunit-doubles-extension.phar tests/phar/tools/phpunit.d/zalas-phpunit-doubles-extension.phar

build/zalas-phpunit-doubles-extension.phar: package
