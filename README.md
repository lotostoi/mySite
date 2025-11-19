# Сайт психолога Анны Волковой

Сайт на Laravel для психолога с красивым landing page.

## Требования к серверу

- PHP 8.1+
- Composer
- MySQL 8.0+ или PostgreSQL
- Nginx или Apache
- 2 vCPU / 2 GB RAM (минимум)

## Установка на локальной машине

1. Клонируйте репозиторий:
```bash
git clone https://github.com/lotostoi/mySite.git
cd mySite
```

2. Установите зависимости:
```bash
composer install
```

3. Скопируйте файл окружения:
```bash
cp .env.example .env
```

4. Сгенерируйте ключ приложения:
```bash
php artisan key:generate
```

5. Настройте базу данных в `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mysite
DB_USERNAME=root
DB_PASSWORD=your_password
```

6. Запустите миграции:
```bash
php artisan migrate
```

7. Запустите сервер разработки:
```bash
php artisan serve
```

Сайт будет доступен по адресу: http://localhost:8000

## Развертывание на Selectel

### 1. Заказ сервера

Рекомендуемая конфигурация:
- **2 vCPU**
- **2 GB RAM**
- **20 GB SSD**
- **Ubuntu 22.04 LTS**
- **Стоимость:** ~590₽/месяц

### 2. Подключение к серверу

```bash
ssh root@ваш_ip_адрес
```

### 3. Установка необходимого ПО

```bash
# Обновление системы
apt update && apt upgrade -y

# Установка Nginx
apt install nginx -y

# Установка PHP 8.1 и расширений
apt install php8.1-fpm php8.1-mysql php8.1-mbstring php8.1-xml php8.1-bcmath php8.1-curl php8.1-zip php8.1-gd -y

# Установка MySQL
apt install mysql-server -y

# Установка Composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer

# Установка Git
apt install git -y
```

### 4. Создание базы данных

```bash
mysql -u root -p

# В MySQL консоли:
CREATE DATABASE mysite CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'mysite_user'@'localhost' IDENTIFIED BY 'strong_password';
GRANT ALL PRIVILEGES ON mysite.* TO 'mysite_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 5. Клонирование проекта

```bash
cd /var/www
git clone https://github.com/lotostoi/mySite.git
cd mySite
```

### 6. Настройка Laravel

```bash
# Установка зависимостей
composer install --no-dev --optimize-autoloader

# Настройка прав
chown -R www-data:www-data /var/www/mySite
chmod -R 755 /var/www/mySite
chmod -R 775 /var/www/mySite/storage
chmod -R 775 /var/www/mySite/bootstrap/cache

# Настройка .env
cp .env.example .env
nano .env
```

В `.env` укажите:
```env
APP_NAME="Анна Волкова"
APP_ENV=production
APP_DEBUG=false
APP_URL=http://ваш_домен_или_ip

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mysite
DB_USERNAME=mysite_user
DB_PASSWORD=strong_password
```

```bash
# Генерация ключа
php artisan key:generate

# Миграции
php artisan migrate --force

# Оптимизация
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 7. Настройка Nginx

```bash
nano /etc/nginx/sites-available/mysite
```

Содержимое файла:
```nginx
server {
    listen 80;
    listen [::]:80;
    server_name ваш_домен_или_ip;
    root /var/www/mySite/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

```bash
# Активация сайта
ln -s /etc/nginx/sites-available/mysite /etc/nginx/sites-enabled/
rm /etc/nginx/sites-enabled/default

# Проверка конфигурации
nginx -t

# Перезапуск Nginx
systemctl restart nginx
```

### 8. Настройка SSL (опционально, но рекомендуется)

```bash
apt install certbot python3-certbot-nginx -y
certbot --nginx -d ваш_домен
```

## Обновление проекта на сервере

```bash
cd /var/www/mySite
git pull origin master
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Структура проекта

- `resources/views/welcome.blade.php` - главная страница сайта
- `routes/web.php` - маршруты приложения
- `public/` - публичная директория (корень сайта)
- `.env` - конфигурация окружения

## Поддержка

По вопросам развертывания обращайтесь к документации Laravel: https://laravel.com/docs
