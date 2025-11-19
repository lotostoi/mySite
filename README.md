# Сайт психолога Анны Волковой

Сайт на Laravel с красивым landing page.

## Требования

- PHP 8.1+
- MySQL 8.0+
- Nginx
- 2GB RAM минимум

## Быстрый старт локально

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

Откройте http://localhost:8000

## Развертывание на Selectel

### Конфигурация сервера
- 2 vCPU / 2 GB RAM / 20 GB SSD
- Ubuntu 22.04
- Цена: ~590 руб/мес

### Установка на сервер

Подключитесь к серверу:
```bash
ssh root@your_ip
```

Установите необходимое ПО:
```bash
apt update && apt upgrade -y
apt install nginx php8.1-fpm php8.1-mysql php8.1-mbstring php8.1-xml php8.1-curl php8.1-zip mysql-server git -y

# Установка Composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer
```

Создайте базу данных:
```bash
mysql -u root -p
```
```sql
CREATE DATABASE mysite CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'mysite_user'@'localhost' IDENTIFIED BY 'strong_password';
GRANT ALL PRIVILEGES ON mysite.* TO 'mysite_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

Клонируйте проект:
```bash
cd /var/www
git clone https://github.com/lotostoi/mySite.git
cd mySite
composer install --no-dev --optimize-autoloader
```

Настройте права:
```bash
chown -R www-data:www-data /var/www/mySite
chmod -R 755 /var/www/mySite
chmod -R 775 /var/www/mySite/storage
chmod -R 775 /var/www/mySite/bootstrap/cache
```

Настройте .env:
```bash
cp .env.example .env
nano .env
```

Измените в .env:
```
APP_ENV=production
APP_DEBUG=false
DB_DATABASE=mysite
DB_USERNAME=mysite_user
DB_PASSWORD=strong_password
```

Запустите миграции:
```bash
php artisan key:generate
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Настройте Nginx:
```bash
nano /etc/nginx/sites-available/mysite
```

Вставьте конфигурацию:
```nginx
server {
    listen 80;
    server_name your_domain_or_ip;
    root /var/www/mySite/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

Активируйте сайт:
```bash
ln -s /etc/nginx/sites-available/mysite /etc/nginx/sites-enabled/
rm /etc/nginx/sites-enabled/default
nginx -t
systemctl restart nginx
```

Установите SSL (опционально):
```bash
apt install certbot python3-certbot-nginx -y
certbot --nginx -d your_domain
```

## Обновление на сервере

```bash
cd /var/www/mySite
git pull origin master
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Структура

- `resources/views/welcome.blade.php` - главная страница
- `routes/web.php` - маршруты
- `public/` - публичная директория

## Ссылки

- GitHub: https://github.com/lotostoi/mySite
- Laravel Docs: https://laravel.com/docs

