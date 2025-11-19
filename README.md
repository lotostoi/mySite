# Сайт психолога Анны Волковой

Сайт на Laravel для психолога с красивым landing page.

---

## Требования к серверу

- PHP 8.1 или выше
- Composer
- MySQL 8.0 или PostgreSQL
- Nginx или Apache
- Минимум 2 vCPU и 2 GB RAM

---

## Установка на локальной машине

### Шаг 1: Клонирование репозитория

    git clone https://github.com/lotostoi/mySite.git
    cd mySite

### Шаг 2: Установка зависимостей

    composer install

### Шаг 3: Настройка окружения

    cp .env.example .env
    php artisan key:generate

### Шаг 4: Настройка базы данных

Откройте файл .env и настройте подключение к базе данных:

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=mysite
    DB_USERNAME=root
    DB_PASSWORD=ваш_пароль

### Шаг 5: Запуск миграций

    php artisan migrate

### Шаг 6: Запуск сервера

    php artisan serve

Сайт будет доступен по адресу: http://localhost:8000

---

## Развертывание на Selectel

### Рекомендуемая конфигурация сервера

- 2 vCPU
- 2 GB RAM
- 20 GB SSD
- Ubuntu 22.04 LTS
- Стоимость: около 590 рублей в месяц

---

## Пошаговая инструкция по развертыванию

### 1. Подключение к серверу

    ssh root@ваш_ip_адрес

### 2. Обновление системы

    apt update && apt upgrade -y

### 3. Установка Nginx

    apt install nginx -y

### 4. Установка PHP 8.1 и расширений

    apt install php8.1-fpm php8.1-mysql php8.1-mbstring php8.1-xml php8.1-bcmath php8.1-curl php8.1-zip php8.1-gd -y

### 5. Установка MySQL

    apt install mysql-server -y

### 6. Установка Composer

    curl -sS https://getcomposer.org/installer | php
    mv composer.phar /usr/local/bin/composer
    chmod +x /usr/local/bin/composer

### 7. Установка Git

    apt install git -y

### 8. Создание базы данных

Подключитесь к MySQL:

    mysql -u root -p

Выполните команды в консоли MySQL:

    CREATE DATABASE mysite CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
    CREATE USER 'mysite_user'@'localhost' IDENTIFIED BY 'strong_password';
    GRANT ALL PRIVILEGES ON mysite.* TO 'mysite_user'@'localhost';
    FLUSH PRIVILEGES;
    EXIT;

### 9. Клонирование проекта

    cd /var/www
    git clone https://github.com/lotostoi/mySite.git
    cd mySite

### 10. Установка зависимостей Laravel

    composer install --no-dev --optimize-autoloader

### 11. Настройка прав доступа

    chown -R www-data:www-data /var/www/mySite
    chmod -R 755 /var/www/mySite
    chmod -R 775 /var/www/mySite/storage
    chmod -R 775 /var/www/mySite/bootstrap/cache

### 12. Настройка файла окружения

    cp .env.example .env
    nano .env

Укажите следующие параметры в .env:

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

### 13. Генерация ключа и миграции

    php artisan key:generate
    php artisan migrate --force

### 14. Оптимизация Laravel

    php artisan config:cache
    php artisan route:cache
    php artisan view:cache

### 15. Настройка Nginx

Создайте конфигурационный файл:

    nano /etc/nginx/sites-available/mysite

Вставьте следующую конфигурацию:

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

### 16. Активация сайта в Nginx

    ln -s /etc/nginx/sites-available/mysite /etc/nginx/sites-enabled/
    rm /etc/nginx/sites-enabled/default
    nginx -t
    systemctl restart nginx

### 17. Установка SSL сертификата (рекомендуется)

    apt install certbot python3-certbot-nginx -y
    certbot --nginx -d ваш_домен

---

## Обновление проекта на сервере

Когда нужно обновить код на сервере:

    cd /var/www/mySite
    git pull origin master
    composer install --no-dev --optimize-autoloader
    php artisan migrate --force
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache

---

## Структура проекта

- resources/views/welcome.blade.php - главная страница сайта
- routes/web.php - маршруты приложения
- public/ - публичная директория (корень сайта)
- .env - конфигурация окружения

---

## Дополнительная информация

Документация Laravel: https://laravel.com/docs

---

## Контакты

GitHub: https://github.com/lotostoi/mySite

