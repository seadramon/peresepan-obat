<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\HasilPemeriksaanRepositoryInterface;
use App\Repositories\HasilPemeriksaanRepository;
use App\Repositories\TandaVitalRepositoryInterface;
use App\Repositories\TandaVitalRepository;
use App\Repositories\ObatRepositoryInterface;
use App\Repositories\ObatRepository;
use App\Repositories\ResepRepositoryInterface;
use App\Repositories\ResepRepository;
use App\Repositories\PasienRepositoryInterface;
use App\Repositories\PasienRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(HasilPemeriksaanRepositoryInterface::class, HasilPemeriksaanRepository::class);

        $this->app->bind(TandaVitalRepositoryInterface::class, TandaVitalRepository::class);

        $this->app->bind(ObatRepositoryInterface::class, ObatRepository::class);

        $this->app->bind(ResepRepositoryInterface::class, ResepRepository::class);

        $this->app->bind(PasienRepositoryInterface::class, PasienRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
