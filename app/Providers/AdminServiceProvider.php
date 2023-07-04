<?php

namespace App\Providers;

use App\Contracts\Services\Admin\UserServiceInterface;
use App\Contracts\Services\Admin\VideoServiceInterface;
use App\Services\Admin\UserService;
use App\Services\Admin\VideoService;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $services = [
            [
                VideoServiceInterface::class,
                VideoService::class
            ],
            [
                UserServiceInterface::class,
                UserService::class
            ]
        ];
        
        foreach ($services as $service) {
            $this->app->bind(
                $service[0],
                $service[1]
            );
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
