<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Cart;
use Auth;
use App\Providers\GlobalFunction;

class DetailController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, $id)
    {
        $product = Product::with(['galleries','user'])->where('slug', $id)->firstOrFail();

        $globalFunction = app('GlobalFunction');
        return view('pages.detail', compact('product','globalFunction'));
    }

    public function add(Request $request, $id)
    {
        // jika belum login
        if (!Auth::id()) {
            return redirect()->route('login')->with(['error' => 'Silahkan login terlebih dahulu']);
        }else{
            // get cart berdasarkan login nya
            $cart = Cart::select('id','products_id','qty')
                    ->where([
                        ['users_id','=', Auth::user()->id],
                        ['products_id','=', $id]
                    ])->first();
            
            // cek data products_id, apakah sudah ada berdasarkan login nya
            if ($cart == NULL) {
                // jika berbeda / belum ada, buat data cart baru
                $data = [
                    'products_id' => $id,
                    'users_id' => Auth::user()->id,
                    'qty' => $request->qty,
                ];
                
                Cart::create($data);
                
            }else{
                // jika product_id nya sama / sudah ada, maka update saja qty cart nya (ditambahkan)
                $carts = Cart::where('id', $cart->id)->first();
                $carts->update(['qty' => $carts->qty + 1]);
            }

        }

        return redirect()->route('cart')->with(['success' => 'Produk ditambahkan ke keranjang']);
    }
}
