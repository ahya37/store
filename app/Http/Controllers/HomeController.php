<?php

namespace App\Http\Controllers;

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
        $products   = Product::with(['galleries'])->inRandomOrder()->take(20)->get();

        $globalFunction = app('GlobalFunction');
        return view('pages.home', compact('categories','products','globalFunction'));
    }

    public function products(Request $request)
    {
        $q = $request->q;
        $products   = Product::with(['galleries'])->where('name','LIKE','%'.$q.'%')->inRandomOrder()->take(20)->get();

        $globalFunction = app('GlobalFunction');
        return view('pages.products', compact('products','globalFunction'));
    }

}
