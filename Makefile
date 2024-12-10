cache-clear:
	 php bin/console cache:clear

stan:
	php vendor/bin/phpstan analyse src tests

fix:
	vendor/bin/php-cs-fixer fix src && vendor/bin/php-cs-fixer fix tests
