<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;

class CategoryController extends Controller
{
   /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::all();
        $products   = Product::with(['galleries'])->paginate(10);
        return view('pages.category', compact('categories','products'));
    }

    public function detail(Request $request, $slug)
    {
        $categories = Category::all();
        $category = Category::where('slug', $slug)->FirstOrFail();
        $products   = Product::with(['galleries'])->where('categories_id', $category->id)->paginate(10);
        return view('pages.category', compact('categories','products'));
    }
}
