<?php

namespace App\Http\Controllers;

use App\Bank;
use App\Http\Requests\PaymentRequest;
use App\Payment;
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
                        })->orderBy('id','DESC')->get();

        $buyTransactions = TransactionDetail::with(['transaction.user','product.galleries'])
                        ->whereHas('transaction', function($transaction){
                            $transaction->where('users_id', Auth::user()->id);
                        })->orderBy('id','DESC')->get();

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
        $transaction = TransactionDetail::with(['transaction.user','product.galleries','transaction.payment'])
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

        $paid = TransactionDetail::with(['transaction.user','product.galleries'])
                        ->whereHas('transaction', function($transaction){
                            $transaction->where('users_id', Auth::user()->id)
                                    ->where('transaction_status','PAID');
                        })->where('shipping_status','PENDING')->get();

        $sending =  TransactionDetail::with(['transaction.user','product.galleries'])
                        ->whereHas('transaction', function($transaction){
                            $transaction->where('users_id', Auth::user()->id);
                        })->where('shipping_status','SHIPPING')
                        ->get();
        
        $finish = TransactionDetail::with(['transaction.user','product.galleries'])
                        ->whereHas('transaction', function($transaction){
                            $transaction->where('users_id', Auth::user()->id);
                        })->where('shipping_status','FINISH')
                        ->get();

        return view('pages.dashboard-transactions-myorder', compact('unpaid','paid','sending','finish'));
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

    public function paymentStore(PaymentRequest $request)
    {
        $data = $request->all();

        
        $data['image'] = $request->file('image')->store('assets/payment','public');
        
        Payment::create($data);
        
        // update PAID pada transaksi
        $transaction = Transaction::where('id',$request->transactions_id)->first();
        $transaction->update(['transaction_status' => 'PAID']);

        return redirect()->route('dashboard-transactions-myorder-detail',['code' => $request->code])->with(['success' => 'Konfirmasi pembayaran berhasil']);
    }

    public function orderFinish($id)
    {
        $transaction = TransactionDetail::where('id', $id)->first();
        $transaction->update(['shipping_status' => 'FINISH']);
        return redirect()->back();
    }

}
