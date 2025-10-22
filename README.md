# Job Railway API

Backend API built with Laravel to manage job offers, applications, companies, and candidates. The project now ships without any frontend assets; every response is JSON.

- **Production**: [https://job-railway-production.up.railway.app](https://job-railway-production.up.railway.app)
- **API Base URL**: [https://job-railway-production.up.railway.app/api](https://job-railway-production.up.railway.app/api)

## Features

- Authentication and user management (register, login, password recovery) backed by Laravel Sanctum tokens.
- CRUD endpoints for job offers, applications, companies, unemployed profiles, trainings, portfolios, classifieds, messages, and comments.
- Authorization policies and form requests to protect data by role (company vs candidate).
- Favorites, application status tracking, and interview scheduling support.

## Local Requirements

- PHP 8.2 or newer
- Composer 2.x
- MySQL 8 (or compatible)
- Redis extension (optional) if you enable queue or cache drivers that depend on it

## Local Setup

```bash
git clone https://github.com/KVN06/Job-Railway.git
cd Job-Railway
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
php artisan serve --host=127.0.0.1 --port=8000
```

The API will be available at `http://127.0.0.1:8000/api`. To list the routes exposed by the backend:

```bash
php artisan route:list --path=api
```

## Key Environment Variables

- `APP_URL`, `ASSET_URL`: public URLs (for production use `https://job-railway-production.up.railway.app`).
- `DB_*`: database credentials; Railway uses the internal host `mysql.railway.internal`.
- `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, `GOOGLE_REDIRECT_URI`: Google OAuth setup.
- `MAIL_*`: transactional email configuration (Elastic Email in production).
- `NIXPACKS_BUILD_CMD`, `NIXPACKS_START_CMD`: commands executed by Railway when building and starting the container.

Review the production `.env` file for the full list of variables currently in use.

## Railway Deployment

The backend is live on Railway at `job-railway-production.up.railway.app`. Recommended setup:

1. Create a Railway service and link this repository.
2. Copy the production environment variables into the Railway Environment tab.
3. Set the custom commands:
   - **Build Command**: `composer install --no-dev --optimize-autoloader && php artisan key:generate --force && php artisan config:clear && php artisan config:cache && php artisan route:clear && php artisan route:cache && php artisan view:clear && php artisan storage:link && php artisan migrate --force && php artisan db:seed`
   - **Start Command**: `php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=${PORT}`
4. Deploy. Each restart will run migrations and seeders to keep the database synchronized.

## Core Endpoints

- `POST /api/login`, `POST /api/register`, `POST /api/logout`, `GET /api/me`
- `GET|POST /api/job-offer`, `GET|PUT|DELETE /api/job-offer/{id}`
- `GET|POST /api/job-application`, `GET|PUT|DELETE /api/job-application/{id}`
- `GET|POST /api/company`, `GET|PUT|DELETE /api/company/{id}`
- `GET|POST /api/unemployed`, `GET|PUT|DELETE /api/unemployed/{id}`
- `GET|POST /api/training`, `GET|PUT|DELETE /api/training/{id}`
- `GET|POST /api/portfolio`, `GET|PUT|DELETE /api/portfolio/{id}`
- `GET|POST /api/message`, `GET|PUT|DELETE /api/message/{id}`
- `GET|POST /api/classified`, `GET|PUT|DELETE /api/classified/{id}`
- `GET|POST /api/favorite`, `GET|PUT|DELETE /api/favorite/{id}`

Attach `Authorization: Bearer {token}` on Sanctum protected endpoints.

## Tests

```bash
php artisan test
```

## License

MIT. See `LICENSE` for details.
