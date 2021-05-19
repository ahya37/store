<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use Auth;

class CartController extends Controller
{
     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $carts = Cart::with(['product.galleries','user.provinces','user.regencies'])->where('users_id', Auth::user()->id)->get();
        $globalFunction = app('GlobalFunction');
        return view('pages.cart', compact('carts','globalFunction'));
    }

    public function delete(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();

        return redirect()->route('cart');
    }


    public function success()
    {
        return view('pages.success');
    }

    public function updateMinus(Request $request, $id)
    {
        // jika request button minus
        if ($request->button == 'minus') {
            // mengambil id carts
            $cart = Cart::findOrFail($id);
            $qty  = $cart->qty - 1; // qty sebelumnya
            $cart->update([
                'qty' => $qty
                ]);
                
            // jika qty tersisa = 0, maka hapus carts
            if ($cart->qty == 0) {
                $cart->delete();
            }
            
        }elseif($request->button == 'plus'){
            // mengambil id carts
            $cart = Cart::findOrFail($id);
            $qty  = $cart->qty + 1; // qty sebelumnya
            $cart->update([
                'qty' => $qty
            ]);

        }
        
        return redirect()->route('cart')->with(['success' => 'Keranjang telah diperbarui']);
        
    }
}
