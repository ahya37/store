<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;

use App\TransactionDetail;
use App\User;
use Auth;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $transactions = TransactionDetail::with(['transaction.user','product.galleries'])
                        ->whereHas('product', function($product){
                            $product->where('users_id', Auth::user()->id);
                        });
        
        // hitung revenue 
        $revenue = $transactions->get()->reduce(function($carry, $item){
            return $carry + $item->price;
        });

        $unpaid = Transaction::where([
                                    ['transaction_status','UNPAID'],
                                    ['users_id', Auth::user()->id]
                                ])->get();

        $shipping = Transaction::where([
                                    ['transaction_status','SHIPPING'],
                                    ['users_id', Auth::user()->id]
                                ])->get();

        $customer = User::count();
        return view('pages.dashboard',[
            'transaction_count' => $transactions->count(),
            'transaction_data'  => $transactions->get(),
            'revenue' => $revenue,
            'customer' => $customer,
            'unpaid' => $unpaid->count(),
            'shipping' => $shipping->count()
        ]);
    }

}
