<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Product;
use App\Promotion;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PromotionController extends Controller
{
    public function index()
    {
        if (request()->ajax()) 
        {
            $query = Promotion::with(['product']);

            return Datatables::of($query)
                ->addColumn('action', function($item){
                    return '
                        <div class="btn-group">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle mr-1 mb-1" type="button" data-toggle="dropdown">Aksi</button>
                                <div class="dropdown-menu">
                                     <form action="'. route('promotion.destroy', $item->id) .'" method="POST">
                                         '. method_field('delete') . csrf_field() .'
                                         <button type="submit" class="dropdown-item text-danger">
                                            Hapus
                                         </button>
                                     </form>
                                </div>
                            </div>
                        </div>
                    ';
                })
                ->rawColumns(['action'])
                ->make();
        }
        return view('pages.admin.promotion.index');
    }
    public function create()
    {
        $products = Product::orderBy('id','DESC')->get();
        return view('pages.admin.promotion.create', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Promotion::create($data);

        return redirect()->route('promotion.index')->with(['Produk promo telah dibuat']);
    }

    public function show()
    {

    }
}
