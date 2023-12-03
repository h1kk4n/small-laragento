<?php
declare(strict_types=1);

namespace App\Console\Commands;

use Database\Seeders\ProductSeeder;
use Illuminate\Console\Command;

class GenerateProducts extends Command
{
    protected $signature = 'laragento:generate:products';
    protected $description = 'Generate random products in amount of 20';

    public function __construct(
        private readonly ProductSeeder $productSeeder
    ) {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->productSeeder->run();
    }
}
