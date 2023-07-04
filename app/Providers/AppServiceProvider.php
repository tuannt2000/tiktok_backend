<?php

namespace App\Providers;

use App\Contracts\Services\Api\CommentServiceInterface;
use App\Contracts\Services\Api\FollowServiceInterface;
use App\Contracts\Services\Api\LanguageServiceInterface;
use App\Contracts\Services\Api\MessageServiceInterface;
use App\Contracts\Services\Api\MusicServiceInterface;
use App\Contracts\Services\Api\RoomServiceInterface;
use App\Contracts\Services\Api\ShareServiceInterface;
use App\Contracts\Services\Api\TagServiceInterface;
use App\Contracts\Services\Api\VideoServiceInterface;
use App\Contracts\Services\Api\UserServiceInterface;
use App\Services\Api\CommentService;
use App\Services\Api\FollowService;
use App\Services\Api\LanguageService;
use App\Services\Api\MessageService;
use App\Services\Api\MusicService;
use App\Services\Api\RoomService;
use App\Services\Api\ShareService;
use App\Services\Api\TagService;
use App\Services\Api\VideoService;
use App\Services\Api\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
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
                LanguageServiceInterface::class,
                LanguageService::class
            ],
            [
                UserServiceInterface::class,
                UserService::class
            ],
            [
                TagServiceInterface::class,
                TagService::class
            ],
            [
                MusicServiceInterface::class,
                MusicService::class
            ],
            [
                RoomServiceInterface::class,
                RoomService::class
            ],
            [
                MessageServiceInterface::class,
                MessageService::class
            ],
            [
                VideoServiceInterface::class,
                VideoService::class
            ],
            [
                FollowServiceInterface::class,
                FollowService::class
            ],
            [
                CommentServiceInterface::class,
                CommentService::class
            ],
            [
                ShareServiceInterface::class,
                ShareService::class
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
