yes | cp -rf .env.example .env && composer install && php artisan migrate && php artisan db:seed && php artisan storage:link && yarn && php artisan key:generate && yarn dev
