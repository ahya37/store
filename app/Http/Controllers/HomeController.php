<?php

namespace App\Http\Controllers;

use App\BestSeller;
use Illuminate\Http\Request;
use App\Category;
use App\Product;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::take(6)->get();
        $product_all = Product::inRandomOrder()->take(20)->paginate(10);
        $product_best_seller = BestSeller::with('product')->get();

        $globalFunction = app('GlobalFunction');
        return view('pages.home', compact('categories','product_best_seller','globalFunction','product_all'));
    }

    public function products(Request $request)
    {
        $q = $request->q;
        $products   = Product::with(['galleries'])->where('name','LIKE','%'.$q.'%')->inRandomOrder()->take(20)->get();

        $globalFunction = app('GlobalFunction');
        return view('pages.products', compact('products','globalFunction'));
    }

}
