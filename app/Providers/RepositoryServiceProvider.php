<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\TicketInterface;
use App\Repositories\TicketRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(TicketInterface::class, TicketRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
