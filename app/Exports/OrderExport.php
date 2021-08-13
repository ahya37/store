<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class OrderExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $start;
    protected $end;

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end   = $end;    
    }
    public function collection()
    {
        return DB::table('orders')
                ->select('date','name','phone_number','address','payment_metode','description_order')
                ->whereBetween('date',[$this->start, $this->end])
                ->get();
    }

    public function headings(): array
    {
        return [
            ['Pemesanan Orderan Tanggal :'.date('d-m-Y', strtotime($this->start)).' s/d '.date('d-m-Y', strtotime($this->end))],
            [''],
            [
                'Tanggal',
                'Nama',
                'No.Hp',
                'Alamat Pengiriman',
                'Metode Pembayaran',
                'Deskripsi Pesanan'
            ]
        ];
    }
}
