<?php

namespace App\Providers;
use App\Models\Article;
use App\Observers\ArticleObserver;
use Illuminate\Support\ServiceProvider;
use App\Models\ArticleRevision;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Article::observe(ArticleObserver::class);

        // Bind {revision_id} to ArticleRevision by id
        Route::bind('id', fn ($value) => Article::findOrFail($value));

    }

}
