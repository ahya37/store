<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        
        $order = Order::whereDate('date','=', date('Y-m-d'))->orderBy('id','DESC')->get();

        if (request()->date != '') {
            
            $order = Order::whereDate('date', request()->date)->orderBy('id','DESC')->get();
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
        Order::create($data);

        return redirect()->route('order.index')->with(['success' => 'Orderan telah ditambahkan']);
    }
}
