<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Point;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use App\Providers\GlobalFunction;

class PointController extends Controller
{
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
                                <button class="btn btn-primary dropdown-toggle mr-1 mb-1" type="button" data-toggle="dropdown">Aksi</button>
                                <div class="dropdown-menu">
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
                'amount_point' => $amount_point
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
                'amount_point'  => $amount_point + $old_amount
            ]);
        }

        return redirect()->route('point.index')->with(['success' => 'Poin telah diambahkan']);
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
                    'amount_point'  => ($nominal_point * $np) + $old_amount
                ]);
            }

        }

        return redirect()->route('point.index')->with(['success' => 'File telah di upload']);
    }

}
