<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OrderExport;
use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function index()
    {
        
        $order = Order::with('users')->whereDate('date','=', date('Y-m-d'))->orderBy('id','DESC')->get();

        #jika filter saja
        if (request()->submit == 'filter') {
            
            if (request()->start != '') {
    
                $start = request()->start;
                $end   = request()->end;
                $order = Order::with('users')->whereBetween('date', [$start, $end])->orderBy('id','DESC')->get();
            }
        }elseif(request()->submit == 'export'){
            
            $date = date('Y-m-d H:i:s');

            $start = request()->start;
            $end   = request()->end;
            $order = Order::with('users')->whereBetween('date', [$start, $end])->orderBy('id','DESC')->get();
            return Excel::download(new OrderExport($start, $end), 'orderan-'.$date.'.xls');
        }
        return view('pages.admin.order.index', compact('order'));
    }
    public function create()
    {
        return view('pages.admin.order.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['users_id'] = Auth::user()->id;
        Order::create($data);

        return redirect()->route('order.index')->with(['success' => 'Orderan telah ditambahkan']);
    }
}
