<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

-   [Simple, fast routing engine](https://laravel.com/docs/routing).
-   [Powerful dependency injection container](https://laravel.com/docs/container).
-   Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
-   Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
-   Database agnostic [schema migrations](https://laravel.com/docs/migrations).
-   [Robust background job processing](https://laravel.com/docs/queues).
-   [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

-   **[Vehikl](https://vehikl.com)**
-   **[Tighten Co.](https://tighten.co)**
-   **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
-   **[64 Robots](https://64robots.com)**
-   **[Curotec](https://www.curotec.com/services/technologies/laravel)**
-   **[DevSquad](https://devsquad.com/hire-laravel-developers)**
-   **[Redberry](https://redberry.international/laravel-development)**
-   **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Deployment / Публикация проекта

Ниже приведены быстрые и проверенные шаги для деплоя этого Laravel-приложения. В первую очередь предназначено для Plesk (pscloud, тариф S) и общего использования.

### Подготовка репозитория

-   Добавьте секреты в `.env` на сервере (не храните `.env` в репозитории).
-   Создайте `.env.example` с примерными переменными окружения.

### Быстрые команды (локально)

```bash
# Убедитесь, что в корне проекта
git init
git add -A
git commit -m "Add deployment instructions and prepare repo"
git branch -M main
git remote add origin https://github.com/<your-username>/<repo>.git
git push -u origin main
```

### Plesk (pscloud) — рекомендации

1. В панели Plesk создайте сайт и укажите домен/поддомен.
2. Установите правильную версию PHP (рекомендуется PHP 8.1/8.2).
3. В разделе «Websites & Domains» используйте "Git" (Plesk поддерживает деплой из репозитория):
    - Подключитесь к GitHub (или укажите URL репозитория) и укажите ветку для деплоя.
    - Выберите режим «Automatic deployment» (или ручной — по вашему выбору).
4. После клонирования в корне проекта (через SSH или Git в Plesk) выполните:

```bash
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
php artisan migrate --force
php artisan storage:link
```

5. В Plesk установите Document Root на `httpdocs`/`public` (в зависимости от структуры Plesk).
6. Убедитесь, что права на `storage` и `bootstrap/cache` корректны (владельцем должен быть веб-пользователь):

```bash
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

7. Настройте переменные окружения в Plesk (Settings → Environment Variables) вместо хранения секретов в репозитории.
8. Включите HTTPS (Let's Encrypt) в Plesk для домена.

### Запуск миграций и задач

После деплоя выполните миграции и создайте ссылку на storage (если не выполнено автоматически):

```bash
php artisan migrate --force
php artisan storage:link
php artisan cache:clear
php artisan config:cache
```

### Примечания

-   Если Plesk не позволяет запускать `composer` на сервере, можно залить `vendor` папку и выполнить на сервере `php artisan storage:link` и остальные команды через SSH.
-   Убедитесь, что `APP_DEBUG=false` и `APP_ENV=production` на продакшне.
-   Для автоматического деплоя с тестами можно настроить GitHub Actions.

Если хотите, я выполню коммит и запушу изменения в ваш репозиторий `https://github.com/bekhruz1723-collab/FoodReciper.git` сейчас.
