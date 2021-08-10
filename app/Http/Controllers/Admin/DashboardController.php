<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Transaction;
use AUth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->access == 'EMPLOY') {
            return redirect()->route('order.index');
        }

        $customer = User::count();
        $revenue  = Transaction::sum('total_price');
        $transaction  = Transaction::count();
        $globalFunction = app('GlobalFunction');
        return view('pages.admin.dashboard', compact('customer','revenue','transaction','globalFunction'));
    }
}
