#### Installation

1. Clone repo
2. Run `composer update`
3. Clone and set up `.env`
4. Run `php artisan migrate`

#### API
For access to Customer and Transaction resources add to headers:
- `Accept: application/json`
- `Authorization: Bearer <api_token>`

#### GUI
Visit `/home` page

#### CRON
Script that stores the sum of all transactions from previous day here: `App\Console\Commands\SumDay.php`

Set up of cron job here: `App\Console\Kernel.php`

#### Tests
Run `vendor/bin/phpunit`