<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use App\Category;
use App\ProductGallery;
use App\IdCard;
use Auth;

use App\Http\Requests\Admin\ProductRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DashboardProductController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $id_card  = IdCard::with(['user'])->where('users_id', Auth::user()->id)->count();
        $products = Product::with(['galleries','category'])->where('users_id', Auth::user()->id)->get();
        
        return view('pages.dashboard-products', compact('products','id_card'));
    }

    public function store(ProductRequest $request)
    {
        $data = $request->all();

        $data['slug'] = Str::slug($request->name);
        $product = Product::create($data);

        $gallery = [
            'products_id' => $product->id,
            'photos' => $request->file('photo')->store('assets/product','public')
        ];

        ProductGallery::create($gallery);

        return redirect()->route('dashboard-product');
    }

    public function details(Request $request, $id)
    {
        $product = Product::with(['galleries','user','category'])->findOrFail($id);
        $categories = Category::all();
        return view('pages.dashboard-products-details', compact('product','categories'));
    }

    public function uploadGallery(Request $request)
    {
        $data = $request->all();

        $data['photos'] = $request->file('photos')->store('assets/product', 'public');

        ProductGallery::create($data);

        return redirect()->route('dashboard-product-details', $request->products_id);
    }

    public function deleteGallery(Request $request, $id)
    {
        $item = ProductGallery::findorFail($id);
        $item->delete();

        return redirect()->route('dashboard-product-details', $item->products_id);
    }

    public function create()
    {
        $categories = Category::all();
        return view('pages.dashboard-products-create', compact('categories'));
    }

    public function update(ProductRequest $request, $id)
    {
        $data = $request->all();

        $item = Product::findOrFail($id);
        $data['slug'] = Str::slug($request->name);

        $item->update($data);

        return redirect()->route('dashboard-product');
    }
   
}
