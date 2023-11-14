# POS Web App

## Installation
1. Install Laragon (on Windows), LAMP (on Linux), or MAMP (on Mac)
2. Enable virtual host, and set the document root to the `public` folder
3. Install commandline dependencies: `composer`
4. Install mongodb driver for php: please google it yourself. [If you use Laragon](https://www.kreaweb.be/laragon-add-mongodb/). Or if you use MAMP: `pecl install mongodb`
5. Clone this repository
6. Run `composer install`
7. Copy `.env.example` to `.env`
8. Modify the DB_DSN and Pusher credentials
9. If you are using new MongoDB, run `php artisan migrate:fresh --seed` and then `php artisan app:apply-role`
10. If you are using your own MongoDB: `php artisan make:filament-user`
11. Run `php artisan serve` to start the server

## Contributing
1. Create a new branch
2. Make changes
3. Commit and push
4. Create a pull request
5. Wait for approval
