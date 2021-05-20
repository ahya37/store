<?php

namespace App\Http\Controllers;

use App\Bank;
use Auth;

use App\Transaction;
use App\TransactionDetail;
use Illuminate\Http\Request;

class DashboardTransactionController extends Controller
{
    public function index()
    {
         $sellTransactions = TransactionDetail::with(['transaction.user','product.galleries'])
                        ->whereHas('product', function($product){
                            $product->where('users_id', Auth::user()->id);
                        })->get();

        $buyTransactions = TransactionDetail::with(['transaction.user','product.galleries'])
                        ->whereHas('transaction', function($transaction){
                            $transaction->where('users_id', Auth::user()->id);
                        })->get();

        return view('pages.dashboard-transactions', compact('sellTransactions','buyTransactions'));
    }

    public function details(Request $request, $id)
    {
        $transaction = TransactionDetail::with(['transaction.user','product.galleries'])
                        ->findOrFail($id);

        return view('pages.dashboard-transactions-details', compact('transaction'));
    }

    public function detailsBuy(Request $request, $id)
    {
        $transaction = TransactionDetail::with(['transaction.user','product.galleries'])
                        ->findOrFail($id);

        return view('pages.dashboard-transactions-details-buy', compact('transaction'));
    }

    public function detailsSell(Request $request, $id)
    {
        $transaction = TransactionDetail::with(['transaction.user','product.galleries'])
                        ->findOrFail($id);

        return view('pages.dashboard-transactions-details-sell', compact('transaction'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $item = TransactionDetail::findOrFail($id);

        $item->update($data);

        return redirect()->route('dashboard-transactions-details', $id);
    }

    public function myOrder()
    {
         $unpaid = Transaction::where([
                                    ['transaction_status','UNPAID'],
                                    ['users_id', Auth::user()->id]
                                ])->get();
        return view('pages.dashboard-transactions-myorder', compact('unpaid'));
    }

    public function myOrderDetail($code)
    {
        $transaction       = Transaction::with(['user.regencies.province'])->where('code', $code)->first();
        $items             = TransactionDetail::with(['product.galleries'])->where('transactions_id', $transaction->id)->get();
        $globalFunction    = app('GlobalFunction');
        return view('pages.dashboard-transactions-myorder-details', compact('transaction','items','globalFunction'));
    }

    public function payment($code)
    {
        $transaction       = Transaction::where('code', $code)->first();
        $banks             = Bank::all();
        return view('pages.dashboard-transactions-payment', compact('banks','transaction'));
        
    }

}
