<?php

namespace Uesley\RouterSummary;

use Illuminate\Support\ServiceProvider;

class RouterSummaryServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/routes.php');
    }
}