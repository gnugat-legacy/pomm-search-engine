#!/usr/bin/env sh

echo ''
echo '// Building test environment'

composer --quiet --no-interaction update --optimize-autoloader > /dev/null
php tests/Fixtures/Project/reset_database.php

echo ''
echo ' [OK] Test environment built'
echo ''


vendor/bin/phpunit && \
    vendor/bin/php-cs-fixer fix --dry-run src && \
    vendor/bin/php-cs-fixer fix --dry-run tests
