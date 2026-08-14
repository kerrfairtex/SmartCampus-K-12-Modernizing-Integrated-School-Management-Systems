# Railway Environment Variables Migration

Move the values from `.env.railway` (currently a plaintext file on disk) into
Railway project **Environment Variables**. Railway injects these at runtime; the
file in the repo is no longer needed and should be git-ignored (it already is).

## SECURITY ACTION REQUIRED
- `.env.railway` contains a plaintext Supabase DB password and uses the SAME
  password as the Supabase Storage secret key. Rotate the Supabase DB password
  in the Supabase dashboard and update these vars.
- Do NOT commit `.env.railway`. (`.gitignore` already blocks `.env*`.)

## Variables to set in Railway (Settings → Variables)
```
APP_NAME=SmartCampus
APP_ENV=production
APP_KEY=            # generate with: php artisan key:generate --show  (on PHP 7.4/8.1)
APP_DEBUG=false
APP_URL=https://your-app.railway.app

# --- Database: Supabase Postgres (already wired) ---
DB_CONNECTION=pgsql
DB_HOST=aws-0-ap-northeast-1.pooler.supabase.com
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres.ebyepweqwihdvjecrufk
DB_PASSWORD=        # ROTATED password, not the leaked one

# --- Cache / Session / Queue → Railway Redis add-on ---
CACHE_DRIVER=redis
SESSION_DRIVER=redis
SESSION_LIFETIME=120
QUEUE_DRIVER=redis
REDIS_HOST=${{Redis.REDIS_HOST}}
REDIS_PASSWORD=${{Redis.REDIS_PASSWORD}}
REDIS_PORT=${{Redis.REDIS_PORT}}

# --- Mail (replace mailtrap with real SMTP in production) ---
MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=null

# --- Broadcasting (leave blank unless using Pusher) ---
PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

# --- Supabase Storage (S3-compatible disk) ---
FILESYSTEM_DRIVER=supabase
FILESYSTEM_CLOUD=supabase
SUPABASE_REGION=ap-northeast-1
SUPABASE_STORAGE_BUCKET=school-files
SUPABASE_STORAGE_ENDPOINT=https://******.supabase.co/storage/v1
SUPABASE_STORAGE_ACCESS_KEY=     # use a Supabase JWT or service-role key
SUPABASE_STORAGE_SECRET_KEY=     # ROTATED; do not reuse the DB password
SUPABASE_URL=https://**********.supabase.co
```

## After deploy
1. `composer require league/flysystem-aws-s3-v3` (Laravel's s3 disk needs it).
2. Set `FILESYSTEM_DRIVER=supabase` so UploadController's
   `Storage::disk('public')->putFile(...)` and UploadHandler's local writes land
   in Supabase Storage instead of Railway's erased container FS.
   (Optionally change the code to `->disk('supabase')` for clarity.)
3. Run `php artisan config:cache` and `php artisan route:cache`.
4. Add the Railway Redis add-on before enabling redis drivers.
