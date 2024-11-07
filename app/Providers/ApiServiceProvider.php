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
        $this->app->bind("App\Repository\IOfferAssignationRepository","App\Repository\OfferAssignationRepository");
        
        $this->app->bind("App\Services\ICartegoryService","App\Services\CategoryService");
        $this->app->bind("App\Services\IUserService","App\Services\UserService");
        $this->app->bind("App\Services\IOfferService","App\Services\OfferService");
        $this->app->bind("App\Services\IOfferImageService","App\Services\OfferImageService");
        $this->app->bind("App\Services\IOfferRequestService","App\Services\OfferRequestService");

        $this->app->bind("App\Interfaces\DateTimeProvider","App\Classes\CurrentDateTimeProvider");
    }

}
