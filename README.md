# Laravel Site - Anna Volkova Psychologist

## Local Setup

composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve

Open http://localhost:8000

## Server Requirements

- PHP 8.1+
- MySQL 8.0+
- Nginx
- 2GB RAM

## Deploy to Selectel

Server: 2 vCPU, 2 GB RAM, Ubuntu 22.04, ~590 RUB/month

### Step 1: Connect
ssh root@your_ip

### Step 2: Install software
apt update && apt upgrade -y
apt install nginx php8.1-fpm php8.1-mysql php8.1-mbstring php8.1-xml php8.1-curl php8.1-zip mysql-server git -y

### Step 3: Install Composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer

### Step 4: Create database
mysql -u root -p

CREATE DATABASE mysite;
CREATE USER 'mysite_user'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON mysite.* TO 'mysite_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;

### Step 5: Clone project
cd /var/www
git clone https://github.com/lotostoi/mySite.git
cd mySite
composer install --no-dev --optimize-autoloader

### Step 6: Set permissions
chown -R www-data:www-data /var/www/mySite
chmod -R 755 /var/www/mySite
chmod -R 775 /var/www/mySite/storage
chmod -R 775 /var/www/mySite/bootstrap/cache

### Step 7: Configure .env
cp .env.example .env
nano .env

Set in .env:
APP_ENV=production
APP_DEBUG=false
DB_DATABASE=mysite
DB_USERNAME=mysite_user
DB_PASSWORD=your_password

### Step 8: Run migrations
php artisan key:generate
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

### Step 9: Configure Nginx
nano /etc/nginx/sites-available/mysite

Add:
server {
    listen 80;
    server_name your_domain;
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

### Step 10: Enable site
ln -s /etc/nginx/sites-available/mysite /etc/nginx/sites-enabled/
nginx -t
systemctl restart nginx

### Step 11: SSL (optional)
apt install certbot python3-certbot-nginx -y
certbot --nginx -d your_domain

## Update

cd /var/www/mySite
git pull origin master
composer install --no-dev
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
