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

composer install
npm install && npm run build
cp .env.example .env
---
- DB_CONNECTION=mysql
- DB_HOST=127.0.0.1
- DB_PORT=3306
- DB_DATABASE=url_shortener
- DB_USERNAME=root
- DB_PASSWORD=your_password
---


php artisan key:generate

php artisan migrate
php artisan serve


