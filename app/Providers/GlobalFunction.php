<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class GlobalFunction extends ServiceProvider
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
        //
    }

    public function __construct(){

    }

    public function formatRupiah($data) {
        $show = number_format((float)$data,0,',','.');
        return $show;
    }
}
