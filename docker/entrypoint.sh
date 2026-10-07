#!/bin/sh
set -e

echo "Waiting for database at ${DB_HOST}:${DB_PORT:-3306}..."
until mysqladmin ping --skip-ssl -h"$DB_HOST" -P"${DB_PORT:-3306}" -u"$DB_USERNAME" -p"$DB_PASSWORD" --silent; do
    sleep 2
done

php artisan package:discover --ansi
php artisan storage:link || true
php artisan migrate --force

# Seed only when the users table is still empty (set RUN_SEED=false to skip)
if [ "${RUN_SEED:-true}" = "true" ]; then
    USERS=$(mysql --skip-ssl -N -s -h"$DB_HOST" -P"${DB_PORT:-3306}" -u"$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" -e "SELECT COUNT(*) FROM users" 2>/dev/null || echo 0)
    if [ "$USERS" = "0" ]; then
        php artisan db:seed --force
    fi
fi

php artisan config:cache
# route:cache is skipped: routes/web.php has a duplicate route name (account.show)
php artisan view:cache

chown -R www-data:www-data storage bootstrap/cache

exec "$@"
