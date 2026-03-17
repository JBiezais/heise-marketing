# Number Queue Service

A REST API service that converts numbers to text format. Numbers are stored in a LIFO (Last In, First Out) queue.

## Table of Contents

- [About](#about)
- [Setup (Sail / Docker)](#setup-sail--docker)
- [Postman Setup](#postman-setup)
  - [Import the collection](#import-the-collection)
  - [Configure the base URL](#configure-the-base-url)
- [API Routes](#api-routes)
  - [Responses](#responses)
  - [Example usage](#example-usage)
- [License](#license)

---

## About

- **Number Queue Service** – converts numbers to text format (e.g. `5` → `"Five"`)
- **LIFO queue** – last added number is retrieved first
- **REST API** – Laravel-based
- **Languages** – English (default), Latvian (optional)
- **Storage** – PostgreSQL

**Tech stack:** Laravel, PostgreSQL, [Laravel Sail](https://laravel.com/docs/sail), [kwn/number-to-words](https://github.com/kwn/number-to-words)

---

## Setup (Sail / Docker)

**Prerequisites:** [Docker Desktop](https://www.docker.com/products/docker-desktop)

1. Clone the repository
2. Copy `.env.example` to `.env`
3. Configure for Sail:
   - `DB_CONNECTION=pgsql`
   - `DB_HOST=pgsql`
   - `DB_PORT=5432`
   - `APP_URL=http://localhost` (or `http://localhost:80` depending on `APP_PORT`)
4. Install dependencies: `composer install`
5. Generate app key: `php artisan key:generate`
6. Start Sail: `./vendor/bin/sail up -d` (or `sail up -d` if using the alias)
7. Run migrations: `./vendor/bin/sail artisan migrate`
8. Access the service at `http://localhost` (or `http://localhost:${APP_PORT}`)

> **Note:** First-time Sail startup may take a few minutes while Docker builds the image.

---

## Postman Setup

### Import the collection

1. Open Postman
2. Go to **File → Import**
3. Select `postman/Number Queue.postman_collection.json` from the project root
4. Alternatively: drag and drop the file into Postman

### Configure the base URL

The collection uses the `{{base_url}}` variable. Set it as follows:

1. Create an **Environment** (or edit the Collection variables)
2. Add variable: `base_url` = `http://localhost` (or `http://localhost:80` if using a different `APP_PORT`)
3. Select the environment in Postman before sending requests

---

## API Routes

| Method | Endpoint       | Description                               | Body / Query                         |
|--------|----------------|-------------------------------------------|--------------------------------------|
| POST   | `/api/numbers` | Add number to queue                       | `number` (form-data, integer ≥ 0)     |
| GET    | `/api/numbers` | Retrieve number from queue as text (LIFO) | `locale` (optional: `en` or `lv`)     |

### Responses

| Status | Description |
|--------|-------------|
| **201** | `{"message": "Number added"}` |
| **200** | `{"text": "Five"}` (or Latvian equivalent with `locale=lv`) |
| **404** | `{"message": "No numbers available in queue"}` when queue is empty |
| **422** | Validation error if `number` is missing, not an integer, or &lt; 0 |

### Example usage

1. **Add numbers:** POST 1, 2, 3, 4, 5 → each returns `{"message": "Number added"}`
2. **Get numbers:** GET → returns `"Five"`, `"Four"`, `"Three"`, `"Two"`, `"One"` (LIFO order)
3. **Empty queue:** GET again → `{"message": "No numbers available in queue"}`

---

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
