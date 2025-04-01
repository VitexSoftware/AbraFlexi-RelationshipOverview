# vim: set tabstop=8 softtabstop=8 noexpandtab:
.PHONY: help
help: ## Displays this list of targets with descriptions
	@grep -E '^[a-zA-Z0-9_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: static-code-analysis
static-code-analysis: vendor ## Runs a static code analysis with phpstan/phpstan
	vendor/bin/phpstan analyse --configuration=phpstan-default.neon.dist --memory-limit=-1

.PHONY: static-code-analysis-baseline
static-code-analysis-baseline: check-symfony vendor ## Generates a baseline for static code analysis with phpstan/phpstan
	vendor/bin/phpstan analyze --configuration=phpstan-default.neon.dist --generate-baseline=phpstan-default-baseline.neon --memory-limit=-1

.PHONY: tests
tests: vendor # PHP Unit
	vendor/bin/phpunit tests

.PHONY: vendor
vendor: composer.json composer.lock ## Installs composer dependencies
	composer install

.PHONY: cs
cs: ## Update Coding Standards
	vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php --diff --verbose

.PHONY: buildimage
buildimage: # Build docker image
	docker build -f Dockerfile  -t vitexsoftware/abraflexi-relationship-overview:latest .

.PHONY: buildx
buildx: # Build multiarch docker image
	docker buildx build  -f Dockerfile  . --push --platform linux/arm/v7,linux/arm64/v8,linux/amd64 --tag vitexsoftware/abraflexi-relationship-overview:`dpkg-parsechangelog | sed -n 's/^Version: //p'| sed 's/~.*//' `

.PHONY: drun
drun: # Run application container
	docker run  -f Dockerfile --env-file .env vitexsoftware/abraflexi-relationship-overview:`dpkg-parsechangelog | sed -n 's/^Version: //p'| sed 's/~.*//' `
