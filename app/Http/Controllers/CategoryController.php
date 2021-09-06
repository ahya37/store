<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\BestSeller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        // $products   = Product::with(['galleries','bestSeller'])->where('categories_id', $category->id)->inRandomOrder()->take(20)->paginate(10);
        $products = DB::table('best_sellers as a')
                    ->rightJoin('products as b','a.product_id','=','b.id')
                    ->rightJoin('product_galleries as c','b.id','=','c.products_id')
                    ->select('b.*','c.photos')
                    ->where('b.categories_id', $category->id)
                    ->whereNull('a.id')
                    ->inRandomOrder()->paginate(10);
        // dd($products);
        $product_best_seller = BestSeller::with(['product.galleries','product' => function($q) use ($category){
            $q->where('categories_id', $category->id);
        }])->get();
        
        // ini dibuat untuk membuat kondisi di view aga jika 
        // tidak ada terlaris jangan di tampilkan section nya
        $best_seller = '';
        foreach ($product_best_seller as $value) {
            $best_seller = $value->product;
        }

        // return $product_best_seller;
        $globalFunction = app('GlobalFunction');

        return view('pages.category-detail', compact('best_seller','category','categories','products','globalFunction','product_best_seller'));
    }
}
