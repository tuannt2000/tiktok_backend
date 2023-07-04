
### docker
docker-compose build
docker-compose up -d

### laravel
Set up set in server docker:
docker exec -it tiktok-app bash
composer install
composer dump-autoload
cp .env.example .env
php artisan config:clear
php artisan key:generate
php artisan migrate:reset
php artisan migrate
php artisan db:seed

php artisan passport:install

composer config --global process-timeout 2000