<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('banks')->insert([
            [
                'name' => 'BANK MANDIRI',
                'owner' => 'PT PERCIKAN IMAN TOURS & TRAVEL',
                'bank_number' => '130.00.1272808.8'
            ],
            [
                'name' => 'BANK BCA',
                'owner' => 'ASEP AWALUDIN',
                'bank_number' => '449.13109.81'
            ],
        ]);
    }
}
