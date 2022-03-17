<?php

namespace App\Providers;

use App\Http\Resources\StudentResource;
use Illuminate\Support\ServiceProvider;
use App\Services\MultiDatabaseHandler;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Models\Setting;
use App\Support\Helpers\SchoolSetting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //$this->app->singleton(new MultiDatabaseHandler);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        StudentResource::withoutWrapping();
        Relation::morphMap([
            'sections' => 'App\Models\Section',
            'exams' => 'App\Models\Exam'
        ]);
    }
}
