<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\Cart;
use App\Transaction;
use App\TransactionDetail;

use Exception;

use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;

class CheckoutController extends Controller
{
    public function process(Request $requst)
    {
        // save user data
        $user  = Auth::user();
        $user->update($requst->except('total_price'));

        // proses checkout
        $code = 'STORE-' . mt_rand(00000,99999);
        $carts = Cart::with(['product','user'])->where('users_id', Auth::user()->id)->get();

        // transaction creat
        $transaction = Transaction::create([
            'users_id' => Auth::user()->id,
            'inscurance_price' => 0,
            'shipping_price' => 0,
            'total_price' => $requst->total_price,
            'transaction_status' => 'PENDING',
            'code' => $code
        ]);

        foreach ($carts as $cart) {
            $trx = 'TRX-' . mt_rand(00000,99999);
            TransactionDetail::create([
            'transactions_id' => $transaction->id,
            'products_id' => $cart->product->id,
            'price' => $cart->product->price,
            'qty'   => $cart->qty,
            'shipping_status' => 'PENDING',
            'resi' => '',
            'code' => $trx
        ]);

        }

        // delete cart data
        Cart::where('users_id', Auth::user()->id)->delete();

        // configurasi midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction   = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // buat array untuk dikirim ke midtrans
        $midtrans = [
            'transaction_details' => [
                'order_id' => $code,
                'gross_amount' => (int) $requst->total_price
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                 'email' => Auth::user()->email
            ],
            'enabled_payments' => [
                'gopay','permata_va','bank_transfer'
            ],
            'vtweb' => []
        ];

        try {
            // Get Snap Payment Page URL
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;
            
            // Redirect to Snap Payment Page
            return redirect($paymentUrl);
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }

    }

    public function callback(Request $requst)
    {
        // set configurasi midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction   = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // instan midtrans notification
        $notification = new Notification();

        // asign ke variabel untuk memudahkan coding
        $staus = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $order_id = $notification->order_id;

        // cari transaksi berdasarkan id
        $transaction = Transaction::findOrFail($order_id);

        // handle midtrans status
        if ($status == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $transaction->status = 'PENDING';
                }
                else{
                    $transaction->status = 'SUCCESS';
                }
            }
        }
        else if($status == 'sattlement'){
            $transaction->status = 'SUCCESS';
        }
        else if($status == 'pending'){
            $transaction->status = 'PENDING';
        }
        else if($status == 'deny'){
            $transaction->status = 'CANCELlED';
        }
        else if($status == 'expire'){
            $transaction->status = 'CANCELlED';
        }
        else if($status == 'cancel'){
            $transaction->status = 'CANCELlED';
        }        

        // simpan transaksi
        $transaction->save();

        // kirimkan email
        if ($transaction) {
            if ($status == 'capture' && $fraud == 'accept') {
                //
            }
            else if ($status == 'settlement') {
                //
            }
            else if ($status == 'success') {
                //
            }
            else if ($status == 'capture' && $fraud == 'challenge') {
                return response()->json([
                    'meta' => [
                        'code' => 200,
                        'message' => 'Midtrans Payment Challenge'
                    ]
                ]);
            }
            else{
                return response()->json([
                    'meta' => [
                        'code' => 200,
                        'message' => 'Midtrans Payment not Challenge'
                    ]
                ]);
            }
            return response()->json([
                    'meta' => [
                        'code' => 200,
                        'message' => 'Midtrans Notification Success'
                    ]
                ]);
        }


    }
}



