<?php

namespace App\Http\Controllers\Admin;

use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        
        $order = Order::with('users')->whereDate('date','=', date('Y-m-d'))->orderBy('id','DESC')->get();

        if (request()->date != '') {
            
            $order = Order::with('users')->whereDate('date', request()->date)->orderBy('id','DESC')->get();
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
