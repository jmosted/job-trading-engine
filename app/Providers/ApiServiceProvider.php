<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {        
        $this->app->bind("App\Repository\ICategoryRepository","App\Repository\CategoryRepository");
        $this->app->bind("App\Repository\IUserRepository","App\Repository\UserRepository");
        $this->app->bind("App\Repository\IOfferRepository","App\Repository\OfferRepository");
        $this->app->bind("App\Repository\IOfferImageRepository","App\Repository\OfferImageRepository");
        $this->app->bind("App\Repository\IOfferRequestRepository","App\Repository\OfferRequestRepository");
        
        $this->app->bind("App\Services\UserServiceI","App\Services\UserService");
        $this->app->bind("App\Services\OfferServiceI","App\Services\OfferService");
        $this->app->bind("App\Services\OfferImageServiceI","App\Services\OfferImageService");
        $this->app->bind("App\Services\OfferRequestServiceI","App\Services\DropletService");
        $this->app->bind("App\Services\CaregoryServiceI","App\Services\CaregoryService");

        $this->app->bind("App\Interfaces\DateTimeProvider","App\Classes\CurrentDateTimeProvider");
    }

}
