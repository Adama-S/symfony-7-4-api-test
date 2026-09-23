# Symfony 7.4 API Test

REST API for managing cocktails and ingredients, built with Symfony 7.4.

## Requirements

- Docker Engine 20.10 or newer
- Docker Compose v2 (`docker compose`)
- Git

The application container uses PHP 8.2 and the database container uses MySQL 8.

## Installation

Follow the complete setup guide in [install.md](install.md).

## API documentation

After starting the application, the OpenAPI documentation is available at:

<http://localhost:8090/api/docs>

## Main endpoints

- `GET /api/cocktails`
- `GET /api/cocktails/{id}`
- `POST /api/cocktails`
- `GET /api/ingredients`
- `GET /api/ingredients/{id}`
- `POST /api/ingredients`

Both collections support partial name filtering with `?name=mojito`.
