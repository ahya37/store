<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Point;
use App\Product;
use App\Transaction;
use App\TransactionDetail;

use App\Providers\CreateBy;
use App\Exports\PointExport;
use Illuminate\Http\Request;
use App\Providers\GlobalFunction;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class PointController extends Controller
{
    public function getCreate()
    {
        $createBy = new CreateBy();
        $getCreateBy = $createBy->getCreateBy();
        return $getCreateBy;
    }
    public function index()
    {
        if (request()->ajax()) 
        {
            $query = Point::with(['user']);

            return Datatables::of($query)
                ->addColumn('action', function($item){
                    return '
                        <div class="btn-group">
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle mr-1 mb-1" type="button" data-toggle="dropdown">Aksi</button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="' .route('point-exchange', $item->id). '">
                                        Tukar Poin
                                     </a>
                                      <a class="dropdown-item" href="' .route('point-exchange-history', $item->users_id). '">
                                        Histori Tukar Poin
                                     </a>
                                     <form action="'. route('point.destroy', $item->id) .'" method="POST">
                                         '. method_field('delete') . csrf_field() .'
                                         <button type="submit" class="dropdown-item text-danger">
                                            Hapus
                                         </button>
                                     </form>
                                </div>
                            </div>
                        </div>
                    ';
                })
                ->rawColumns(['action'])
                ->make();
        }
        return view('pages.admin.point.index');
    }

    public function create()
    {
        return view('pages.admin.point.create');
    }

    public function store(Request $request)
    {
        $point = Point::where('users_id', $request->users_id)->first();
        
        if ($point == NULL) {
            // menghitung point dari setiap transaksi
            $globalFunction = new GlobalFunction();
            $point          = $globalFunction->point($request->nominal);
            $nominal_point  = $point['nominalPoint'];
            $amount_point   = $point['amountPoint'];
    
            // simpan point setiap kali transaksi
            Point::create([
                'users_id' => $request->users_id,
                'nominal_point' => $nominal_point,
                'amount_point' => $amount_point,
                'create_by' => $this->getCreate()
            ]);
           
        }else{

            // tambahkan data sebelumnya dengan nominal dan amount yang baru
            $globalFunction = new GlobalFunction();
            $newpoint       = $globalFunction->point($request->nominal);
            $nominal_point  = $newpoint['nominalPoint'];
            $amount_point   = $newpoint['amountPoint'];

            $old_nominal = $point->nominal_point;
            $old_amount  = $point->amount_point;

            $oldpoint = Point::where('id', $point->id)->first();
            $oldpoint->update([
                'nominal_point' =>  $nominal_point + $old_nominal,
                'amount_point'  => $amount_point + $old_amount,
                'create_by' => $this->getCreate()
            ]);
        }

        return redirect()->route('point.index')->with(['success' => 'Poin telah ditambahkan']);
    }

    public function destroy($id)
    {
        $item = Point::findOrFail($id);
        $item->delete();

        return redirect()->route('point.index')->with(['success' => 'Poin telah dihapus']);
    }

    public function uploadPointExcel(Request $request)
    {
        include app_path('Providers/ExcelReader.php');

        $jumlahBaris = $jumlah_baris;
        $datapoint   = $data;
        $countData   = 0;
        $no          = 1;

        for ($i=2; $i <= $jumlahBaris ; $i++) { 
            if ($datapoint->val($i, 2) != null) {
                $countData += count(array($i));
            }
        }

        $countData = $countData;

        return view('pages.admin.excel-reader.index', compact('no','jumlahBaris','datapoint','countData'));
    }

    public function saveExcelUploadPoint(Request $request)
    {
        ini_set('max_input_vars','1000');

        $users_id = $request->input('users_id');
        $amount_point = $request->input('amount');

        foreach ($users_id as $key => $value) {

            $point = Point::where('users_id', $value)->first();

            if ($point == NULL ) {
                $n  = $amount_point[$key];
                $mt = 250000;
                $np = 100;
                $mp = 10;
    
                $nominal_point = floor(($n/$mt) * $mp);
    
                $point = new Point();
                $point->users_id = $value;
                $point->nominal_point = $nominal_point;
                $point->amount_point = $nominal_point * $np;
                $point->create_by = $this->getCreate();
                $point->save();

            }else{

                $n  = $amount_point[$key];
                $mt = 250000;
                $np = 100;
                $mp = 10;
    
                $nominal_point = floor(($n/$mt) * $mp);
                
                $old_nominal = $point->nominal_point;
                $old_amount  = $point->amount_point;

                $oldpoint = Point::where('id', $point->id)->first();

                $oldpoint->update([
                    'nominal_point' => $nominal_point + $old_nominal,
                    'amount_point'  => ($nominal_point * $np) + $old_amount,
                    'create_by' => $this->getCreate()
                ]);
            }

        }

        return redirect()->route('point.index')->with(['success' => 'File telah di upload']);
    }

    public function exchangePoint($id)
    {
       $point = Point::with(['user'])->findOrFail($id);
       $products = Product::select('id','point','name','price')->where('point','!=',0)->get();
       $globalFunction = app('GlobalFunction');

       return view('pages.admin.point.exchange-point', compact('point','products','globalFunction'));
    }

    public function StoreexchangePoint(Request $request, $id)
    {
            $users_id    = $request->input('users_id'); 
            $products_id = $request->input('products_id');
            $price       = $request->input('price');
            
            foreach ($products_id as $key => $value) {
                // get price dari masing2 produk
                $products[] = Product::select('id','price','point')->where('id', $products_id[$key])->first();
                // menghitung total harga
                $total_price = collect($products)->sum(function($q){
                    return $q['price'];
                });

                $total_point = collect($products)->sum(function($q){
                    return $q['point'];
                });
            };

            // jika jumlah point yang di tukarkan melebihi point yang dimiliki, maka peringati
            $point = Point::where('users_id', $users_id)->first();
            if ($total_point > $point->nominal_point ) {
                return redirect()->back()->with(['error' => 'Point belum mencukupi untuk ditukarkan']);

            }else{
                // simpan transaksi
                $code = 'STORE-' . mt_rand(00000,99999);
                $transaction = Transaction::create([
                        'users_id' => $users_id,
                        'inscurance_price' => 0,
                        'shipping_price' => 0,
                        'total_price' => $total_price,
                        'transaction_status' => 'PAID',
                        'exchange_point' => 1,
                        'code' => $code
                ]);
                
                // simpan detail transaksi
                foreach ($products_id as $index => $val) {
                        $trx = 'TRX-' . mt_rand(00000,99999);
                        TransactionDetail::create([
                            'transactions_id' => $transaction->id,
                            'products_id' => $val,
                            'price' => $price[$index],
                            'qty'   => 1,
                            'shipping_status' => 'PENDING',
                            'resi' => '',
                            'code' => $trx
                        ]);
                }
    
                $nominal_point = $point->nominal_point - $total_point;
                $amount_point  = $nominal_point * 100;
                $point->update([
                    'nominal_point' => $nominal_point,
                    'amount_point'  => $amount_point,
                    'create_by' => $this->getCreate()
                ]);

            }


            return redirect()->route('point.index')->with(['success' => 'Point telah ditukarkan']);

    }

    public function historyExchangePoint($users_id)
    {
        if (request()->ajax()) 
        {
            $query = Transaction::with(['user'])->where([
                ['users_id', $users_id],
                ['exchange_point','=',1]
            ]);

            return Datatables::of($query)
                ->addColumn('action', function($item){
                    return '
                        <div class="btn-group">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle mr-1 mb-1" type="button" data-toggle="dropdown">Aksi</button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="' .route('transactions.show', $item->id). '">
                                        Lihat
                                     </a>
                                     <form action="'. route('transactions.destroy', $item->id) .'" method="POST">
                                         '. method_field('delete') . csrf_field() .'
                                         <button type="submit" class="dropdown-item text-danger">
                                            Hapus
                                         </button>
                                     </form>
                                </div>
                            </div>
                        </div>
                    ';
                })
                ->rawColumns(['action'])
                ->make();
        }
        return view('pages.admin.point.history-exchange-point');
        
    }

    public function downloadFormatExcel()
    {
        $time = time();
        return Excel::download(new PointExport(), 'points-'.$time.'.xls');
    }

}
