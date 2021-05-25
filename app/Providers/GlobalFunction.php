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

    public function point($total_price)
    {
        
        $n = $total_price;
        $mt = 250000; // minimal transaksi
        $np = 100; // nilai poin
        $mp = 10; // miminum poin

        $amountPoint = 0;
        $nominalPoint = floor(($n/$mt) * $mp);
        $amountPoint = $nominalPoint * $np;

        $dataPoint = ['nominalPoint' => $nominalPoint,'amountPoint' => $amountPoint];
        return $dataPoint;
    }
}
