# Psychologist Anna Volkova Website

Laravel website with beautiful landing page.

## Quick Start

Install dependencies:
```
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

Open http://localhost:8000

## Server Requirements

- PHP 8.1+
- MySQL 8.0+
- Nginx
- 2GB RAM minimum

## Deployment on Selectel

### Server Config
- 2 vCPU / 2 GB RAM / 20 GB SSD
- Ubuntu 22.04
- Cost: ~590 RUB/month

### Installation Steps

Connect to server:
```
ssh root@your_ip
```

Install software:
```
apt update && apt upgrade -y
apt install nginx php8.1-fpm php8.1-mysql php8.1-mbstring php8.1-xml php8.1-curl php8.1-zip mysql-server git -y

curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer
```

Create database:
```
mysql -u root -p
```

Run in MySQL:
```
CREATE DATABASE mysite CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'mysite_user'@'localhost' IDENTIFIED BY 'strong_password';
GRANT ALL PRIVILEGES ON mysite.* TO 'mysite_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

Clone and setup:
```
cd /var/www
git clone https://github.com/lotostoi/mySite.git
cd mySite
composer install --no-dev --optimize-autoloader
```

Set permissions:
```
chown -R www-data:www-data /var/www/mySite
chmod -R 755 /var/www/mySite
chmod -R 775 /var/www/mySite/storage
chmod -R 775 /var/www/mySite/bootstrap/cache
```

Configure .env:
```
cp .env.example .env
nano .env
```

Update .env file:
```
APP_ENV=production
APP_DEBUG=false
DB_DATABASE=mysite
DB_USERNAME=mysite_user
DB_PASSWORD=strong_password
```

Run migrations:
```
php artisan key:generate
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Configure Nginx:
```
nano /etc/nginx/sites-available/mysite
```

Add configuration:
```
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

Enable site:
```
ln -s /etc/nginx/sites-available/mysite /etc/nginx/sites-enabled/
rm /etc/nginx/sites-enabled/default
nginx -t
systemctl restart nginx
```

Install SSL:
```
apt install certbot python3-certbot-nginx -y
certbot --nginx -d your_domain
```

## Update Project

```
cd /var/www/mySite
git pull origin master
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Links

- GitHub: https://github.com/lotostoi/mySite
- Laravel: https://laravel.com/docs
