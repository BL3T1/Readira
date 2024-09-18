<?php

namespace App\Providers;

use App\Services\Services\BookService;
use Illuminate\Support\ServiceProvider;
use App\Services\Services\ReportService;
use App\Services\Services\CommentService;
use App\Services\Services\ProgressService;
use App\Services\Services\CollectionService;
use App\Custom\Services\EmailVerficationService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(EmailVerficationService::class);

        $this->app->bind('BookService', function () {
            return new BookService();
        });
        $this->app->bind('CollectionService', function () {
            return new CollectionService();
        });
        $this->app->bind('CommentService', function () {
            return new CommentService();
        });
        $this->app->bind('ProgressService', function () {
            return new ProgressService();
        });
         $this->app->bind('ReportService', function () {
            return new ReportService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
