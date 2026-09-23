# Installation

## Prerequisites

- Git
- Docker Engine 20.10 or newer
- Docker Compose v2

The project runs with PHP 8.2, Symfony 7.4 and MySQL 8 inside Docker. PHP,
Composer and the Symfony CLI do not need to be installed on the host machine.

## Setup

1. Clone the repository:

   ```bash
   git clone https://github.com/Adama-S/symfony-7-4-api-test.git
   cd symfony_7_4_api_test
   ```

2. Build and start the containers:

   ```bash
   docker compose up -d --build
   ```

3. Open a shell in the application container:

   ```bash
   [winpty] docker compose exec app sh
   ```

4. Install the locked PHP dependencies:

   ```bash
   cd /var/www/html/api
   composer install
   ```

5. Create the database schema and load the development fixtures:

   ```bash
   bin/initialize
   ```

   This command drops and recreates the database. Do not run it against
   production data.

6. Start the Symfony development server:

   ```bash
   symfony serve --allow-http --no-tls --listen-ip=0.0.0.0 -d
   ```

   The API is then available at <http://localhost:8090>.

## API documentation

Open <http://localhost:8090/api/docs> to view the generated OpenAPI
documentation.

## Useful commands

Run these commands from `/var/www/html/api` inside the `app` container:

```bash
# Clear the Symfony cache
php bin/console cache:clear

# Check Doctrine mappings
php bin/console doctrine:schema:validate
```

Run this command from the repository root on the host to follow application
logs:

```bash
docker compose logs -f app
```

To stop the containers:

```bash
docker compose down
```

To remove the containers and the database volume:

```bash
docker compose down --remove-orphans --volumes
```
