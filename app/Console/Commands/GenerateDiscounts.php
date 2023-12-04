<?php
declare(strict_types=1);

namespace App\Console\Commands;

use Database\Seeders\DiscountSeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Console\Command;

class GenerateDiscounts extends Command
{
    protected $signature = 'laragento:generate:discounts';
    protected $description = 'Generate random discounts in amount of 5';

    public function __construct(
        private readonly DiscountSeeder $discountSeeder
    ) {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->discountSeeder->run();
    }
}
