<?php

namespace App\NumberQueue;

use Illuminate\Support\ServiceProvider;

class NumberQueueServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
        $this->loadRoutesFrom(__DIR__.'/Http/Routes/NumberQueueRoutes.php');
    }
}
