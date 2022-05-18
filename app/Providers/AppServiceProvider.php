<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use View;
use Activity;
use App\KategoriBagian;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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
        /**
         * Paginate a standard Laravel Collection.
         *
         * @param int $perPage
         * @param int $total
         * @param int $page
         * @param string $pageName
         * @return array
         */
        Collection::macro('paginate', function ($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            return new LengthAwarePaginator(
                $this->forPage($page, $perPage)->values(),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });

        Schema::defaultStringLength(191);
        setlocale(LC_ALL, 'id_ID.utf8');
        // Carbon::setLocale('id_ID.utf8');

        // Harus dicomment jika mau migrate table
        $now = Carbon::now();
        if (Schema::hasTable('sessions')){
            $activities = Activity::usersBySeconds(30)->get();
            $numberOfUsers = Activity::users()->count();
            View::share ( 'numberOfUsers', $numberOfUsers );
            View::share ( 'now', $now );
        }

        if (Schema::hasTable('kategori_bagians')){
            $polres_list = KategoriBagian::select('id', 'name')->where('kategori_id', 2)->orderBy('name', 'asc')->get();
            View::share ( 'polres_list', $polres_list );
        }

    }
}
