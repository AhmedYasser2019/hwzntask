<?php

namespace App\Providers;

use App\Repositories\Contracts\IDevice;
use App\Repositories\Contracts\IUser;
use App\Repositories\SQL\DeviceRepository;
use App\Repositories\SQL\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(IUser::class, UserRepository::class);
        $this->app->bind(IDevice::class, DeviceRepository::class);

    }
}
