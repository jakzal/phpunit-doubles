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

cs: tools/php-cs-fixer
	tools/php-cs-fixer --dry-run --allow-risky=yes --no-interaction --ansi fix
.PHONY: cs

cs-fix: tools/php-cs-fixer
	tools/php-cs-fixer --allow-risky=yes --no-interaction --ansi fix
.PHONY: cs-fix

deptrac: tools/deptrac
	tools/deptrac --no-interaction --ansi --formatter-graphviz-display=0
.PHONY: deptrac

infection: tools/infection tools/infection.pubkey
	phpdbg -qrr ./tools/infection --no-interaction --formatter=progress --min-msi=100 --min-covered-msi=100 --only-covered --ansi
.PHONY: infection

phpunit: tools/phpunit
	tools/phpunit
.PHONY: phpunit

phpunit-coverage: tools/phpunit
	phpdbg -qrr tools/phpunit
.PHONY: phpunit

tools: tools/php-cs-fixer tools/deptrac tools/infection
.PHONY: tools

clean:
	rm -rf build
	rm -rf vendor
	find tools -not -path '*/\.*' -type f -delete
.PHONY: clean

vendor: install

vendor/bin/phpunit: install

tools/phpunit: vendor/bin/phpunit
	ln -sf ../vendor/bin/phpunit tools/phpunit

tools/php-cs-fixer:
	curl -Ls http://cs.sensiolabs.org/download/php-cs-fixer-v2.phar -o tools/php-cs-fixer && chmod +x tools/php-cs-fixer

tools/deptrac:
	curl -Ls http://get.sensiolabs.de/deptrac.phar -o tools/deptrac && chmod +x tools/deptrac

tools/infection: tools/infection.pubkey
	curl -Ls https://github.com/infection/infection/releases/download/0.9.0/infection.phar -o tools/infection && chmod +x tools/infection

tools/infection.pubkey:
	curl -Ls https://github.com/infection/infection/releases/download/0.9.0/infection.phar.pubkey -o tools/infection.pubkey
