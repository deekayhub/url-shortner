# 🔗 Laravel URL Shortener

Url shortner app

---

## Features
- Generate short codes (6–8 characters)
- Redirect with **301/302**
- De-duplication (same URL → same code)
- Optional expiration (TTL or absolute datetime)
- Simple Bootstrap frontend

---

## 🚀 Getting Started

### 1. Clone the repository
```bash
git clone https://github.com/your-username/url-shortener.git
cd url-shortener

# Install PHP dependencies
composer install

# Install frontend dependencies and build assets
npm install && npm run build

# Copy the environment file
cp .env.example .env

or

copy .env.example .env

php artisan key:generate

php artisan migrate
php artisan serve


