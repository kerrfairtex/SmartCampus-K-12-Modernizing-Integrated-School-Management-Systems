#!/bin/sh
set -e

# --- Config from environment (Render injects these) ---
APP_NAME="${APP_NAME:-SmartCampus}"
APP_ENV="${APP_ENV:-production}"
APP_URL="${APP_URL:-https://smartcampus-k12.onrender.com}"
APP_DEBUG="${APP_DEBUG:-false}"
DB_CONNECTION="${DB_CONNECTION:-pgsql}"
DB_HOST="${DB_HOST:-aws-0-ap-northeast-1.pooler.supabase.com}"
DB_PORT="${DB_PORT:-6543}"
DB_DATABASE="${DB_DATABASE:-postgres}"
DB_USERNAME="${DB_USERNAME:-postgres.ebyepweqwihdvjecrufk}"
DB_PASSWORD="${DB_PASSWORD:-}"
CACHE_DRIVER="${CACHE_DRIVER:-file}"
# database driver: Railway's filesystem is ephemeral — file sessions vanish on
# every restart/redeploy, breaking login (CSRF 419). Postgres is always there.
SESSION_DRIVER="${SESSION_DRIVER:-database}"
QUEUE_DRIVER="${QUEUE_DRIVER:-sync}"
FILESYSTEM_DRIVER="${FILESYSTEM_DRIVER:-public}"
UPLOADS_DISK="${UPLOADS_DISK:-public}"

# APP_KEY: generate one if not provided (sessions/encryption need a stable key)
if [ -z "${APP_KEY:-}" ]; then
    APP_KEY="base64:$(php -r 'echo base64_encode(random_bytes(32));')"
fi

# --- Write .env ---
cat > /var/www/html/.env <<EOF
APP_NAME=${APP_NAME}
APP_ENV=${APP_ENV}
APP_KEY=${APP_KEY}
APP_DEBUG=${APP_DEBUG}
APP_LOG_LEVEL=error
APP_URL=${APP_URL}
APP_SERVERLESS=false

DB_CONNECTION=${DB_CONNECTION}
DB_HOST=${DB_HOST}
DB_PORT=${DB_PORT}
DB_DATABASE=${DB_DATABASE}
DB_USERNAME=${DB_USERNAME}
DB_PASSWORD=${DB_PASSWORD}

BROADCAST_DRIVER=log
CACHE_DRIVER=${CACHE_DRIVER}
SESSION_DRIVER=${SESSION_DRIVER}
SESSION_LIFETIME=120
QUEUE_DRIVER=${QUEUE_DRIVER}
FILESYSTEM_DRIVER=${FILESYSTEM_DRIVER}
UPLOADS_DISK=${UPLOADS_DISK}

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1
EOF

cd /var/www/html

# --- One-time init (idempotent, best-effort so a failure never blocks startup) ---
php artisan package:discover 2>&1 | tail -2 || true
php artisan migrate --force --no-interaction 2>&1 | tail -8 || true
php artisan passport:keys --force 2>&1 | tail -2 || true
php artisan config:cache 2>&1 || true
php artisan view:cache 2>&1 || true
php artisan storage:link 2>&1 || true

# --- Apache: bind to Render's \$PORT (default 10000) and serve public/ ---
PORT="${PORT:-10000}"
printf 'Listen %s\n' "${PORT}" > /etc/apache2/ports.conf

cat > /etc/apache2/sites-available/000-default.conf <<CONF
<VirtualHost *:${PORT}>
    DocumentRoot /var/www/html/public
    <Directory /var/www/html/public>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
CONF

# --- Apache MPM fix (AH00534 -> crash -> Railway 502) ---
# php:8.1-apache ships BOTH mpm_event and mpm_prefork enabled via symlinks in
# mods-enabled. Apache refuses to start with more than one MPM loaded. Keep
# only mpm_prefork (required by mod_php). Runtime removal is deterministic;
# build-time removal is defeated by Railway layer caching.
rm -f /etc/apache2/mods-enabled/mpm_event.load \
      /etc/apache2/mods-enabled/mpm_event.conf \
      /etc/apache2/mods-enabled/mpm_worker.load \
      /etc/apache2/mods-enabled/mpm_worker.conf

# Silence the AH00558 FQDN warning (cosmetic)
if ! grep -q '^ServerName' /etc/apache2/apache2.conf; then
    echo "ServerName localhost" >> /etc/apache2/apache2.conf
fi

exec apache2-foreground
