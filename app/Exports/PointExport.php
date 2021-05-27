<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class PointExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('users as a')
                ->leftJoin('points as b','b.users_id','=','a.id')
                ->select('a.id','a.name','b.amount_point')
                ->where('a.roles','!=','ADMIN')
                ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'Nominal Transaksi'
        ];
    }
}
