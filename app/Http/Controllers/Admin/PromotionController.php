<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Product;
use App\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function create()
    {
        $products = Product::orderBy('id','DESC')->get();
        return view('pages.admin.promotion.create', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Promotion::create($data);

        return redirect()->route('promotion.create')->with(['Produk promo telah dibuat']);
    }

    public function show()
    {

    }
}
