# TravelEasy

TravelEasy is a web application for a travel agency, built as a school project at MBO Utrecht. Customers can browse trips, destinations and offers, and staff can manage bookings, customers, accounts, invoices and trip overviews from a dashboard.

## Features

- **Trips & destinations**: trip listings with date filtering (Flatpickr), destinations and packages
- **Offers** (`/aanbiedingen`): trips with discount codes
- **Bookings**: create, view and edit bookings
- **Trip overview** (`/reisoverzicht`): manage trips (create, edit, delete)
- **Customers & accounts**: customer list and account management
- **Invoices**
- **Messages & chat**: messaging between users, plus a chatbot powered by the Hugging Face API
- **Authentication & roles**: login/registration (Laravel Breeze) with roles such as Admin

## Tech stack

- PHP 8.2+ / Laravel 11
- MySQL 8 (the app uses stored procedures, so MySQL/MariaDB is required)
- Blade, Tailwind CSS (via CDN), Alpine.js, Vite
- Docker (PHP 8.3 + Apache, MySQL 8)

## Running with Docker (recommended)

Requirements: [Docker Desktop](https://www.docker.com/products/docker-desktop/) (or Docker Engine with Compose).

1. Clone the repository:
   ```bash
   git clone https://github.com/NimrodLobozar/TravelEasy.git
   cd TravelEasy
   ```
2. Make sure an `APP_KEY` is available. Docker Compose reads it from a `.env` file in the project folder. If you don't have one yet:
   ```bash
   echo "APP_KEY=base64:$(openssl rand -base64 32)" > .env
   ```
3. Build and start:
   ```bash
   docker compose up -d --build
   ```
4. Open **http://localhost:8080**

On the first start the container waits for the database, runs the migrations and seeds test data (only when the database is empty).

### Test accounts

| Role  | Email             | Password    |
|-------|-------------------|-------------|
| Admin | `admin@gmail.com` | `Admin1234` |
| User  | `test@gmail.com`  | `Test1234`  |

### Environment variables

| Variable                  | Default                 | Description                                          |
|---------------------------|-------------------------|------------------------------------------------------|
| `APP_KEY`                 | *(required)*            | Laravel encryption key (`base64:...`)                |
| `APP_URL`                 | `http://localhost:8080` | Public URL of the app                                |
| `APP_PORT`                | `8080`                  | Port on the host                                     |
| `APP_ENV`                 | `production`            | Laravel environment                                  |
| `APP_DEBUG`               | `false`                 | Show detailed error pages                            |
| `DOCKER_DB_PASSWORD`      | `traveleasy`            | Password for the `traveleasy` MySQL user             |
| `DOCKER_DB_ROOT_PASSWORD` | `root`                  | MySQL root password                                  |
| `RUN_SEED`                | `true`                  | Seed test data when the database is empty            |
| `HUGGINGFACE_API_KEY`     | *(empty)*               | API key for the chatbot                              |

**Change the database passwords** for anything other than local testing.

### Useful commands

```bash
docker compose logs -f app                              # follow app logs
docker compose exec app php artisan migrate:fresh --seed --force   # reset the database
docker compose down                                     # stop
docker compose down -v                                  # stop and delete all data
```

## Deploying on CasaOS with Portainer

1. In Portainer, go to **Stacks → Add stack → Repository**.
2. Repository URL: `https://github.com/NimrodLobozar/TravelEasy`, reference: `refs/heads/main`, compose path: `docker-compose.yml`.
3. Under **Environment variables** add at least `APP_KEY`, `APP_URL` (e.g. `http://<casaos-ip>:8080`), `DOCKER_DB_PASSWORD` and `DOCKER_DB_ROOT_PASSWORD`. Set `APP_PORT` if port 8080 is already in use.
4. Click **Deploy the stack**. Portainer builds the image on the server.

To update after new commits on `main`, use **Pull and redeploy** on the stack.

## Running locally without Docker

Requirements: PHP 8.2+, Composer, Node.js, MySQL.

```bash
composer install
npm install
# create a .env file with DB_* settings pointing to your MySQL database
php artisan key:generate
php artisan migrate --seed
npm run build
php artisan serve
```

## Branches

- `main`: stable version, used for deployment
- `Dev`: integration branch; feature branches are merged here first, then into `main`
- Personal/feature branches: `Nimrod`, `Ashutosh`, `Martijn`, `Thomas`, `Feature`

## Team

GitHub contributors: [NimrodLobozar](https://github.com/NimrodLobozar), [LorenzoABS](https://github.com/LorenzoABS), [Martijn339074](https://github.com/Martijn339074), [ThomasTadesse](https://github.com/ThomasTadesse)
