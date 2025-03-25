<?php

namespace App\Providers;

use App\Contracts\TaskRepositoryContracts;
use App\Contracts\TaskServiceContracts;
use App\Repositories\TaskRepository;
use App\Services\TaskService;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TaskServiceContracts::class, TaskService::class);
        $this->app->bind(TaskRepositoryContracts::class, TaskRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
    }
}
