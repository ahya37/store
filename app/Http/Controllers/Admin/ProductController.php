<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Product;
use App\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\ProductRequest;
use App\TopCategory;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) 
        {
            $query = Product::with(['user','category']);

            return Datatables::of($query)
                ->addColumn('action', function($item){
                    return '
                        <div class="btn-group">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle mr-1 mb-1" type="button" data-toggle="dropdown">Aksi</button>
                                <div class="dropdown-menu">
                                     <a class="dropdown-item" href="' .route('product.edit', $item->id). '">
                                        Edit
                                     </a>
                                     <form action="'. route('product.destroy', $item->id) .'" method="POST">
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
        return view('pages.admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $categories = Category::all();
        return view('pages.admin.product.create', compact('users','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $data = $request->all();

        $data['slug'] = Str::slug($request->name);
        Product::create($data);

        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Product::findOrFail($id);
        $users = User::all();
        $categories = Category::all();

        return view('pages.admin.product.edit', compact('users','categories','item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        $item = Product::findOrFail($id);
        $data['slug'] = Str::slug($request->name);

        $item->update($data);

        return redirect()->route('product.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Product::findOrFail($id);
        $item->delete();

        return redirect()->route('product.index');
    }

    public function downloadFormatExcel()
    {
        $path = public_path('fileformat/products.xls');
        return Response::download($path);

    }

    public function uploadProductExcel(Request $request)
    {
        include app_path('Providers/ExcelReader.php');

        $jumlahBaris = $jumlah_baris;
        $datapoint   = $data;
        $countData   = 0;
        $no          = 1;

        $top_categories = '';
        for ($i=2; $i <= $jumlahBaris ; $i++) { 
            if ($datapoint->val($i, 2) != null) {
                $countData += count(array($i));
            }
            // $datapoint->val($i, 1) adalah nama
            $top_categories = TopCategory::where('name', $datapoint->val($i, 3))->first();
            $categories = Category::where('name', $datapoint->val($i, 4))->first();

            if (empty($top_categories)) {
               return redirect()->back()->with(['error' => 'Data Kategori atau Sub Kategori ada yang tidak sesuai, periksa kembali!']);
            }
            if (empty($categories)) {
               return redirect()->back()->with(['error' => 'Data Kategori atau Sub Kategori ada yang tidak sesuai, periksa kembali!']);
            }
        }
        
        $countData       = $countData;
        return view('pages.admin.excel-reader.product', compact('no','jumlahBaris','datapoint','countData'));
    }

    public function saveExcelUploadPoint(Request $request)
    {
        ini_set('max_input_vars','1000');

        $name = $request->input('name');
        $users_id = $request->input('users_id');
        $top_categories_id = $request->input('top_categories_id');
        $categories_id = $request->input('categories_id');
        $price = $request->input('price');
        $stock = $request->input('stock');
        $weight = $request->input('weight');
        $profit_sharing = $request->input('profit_sharing');
        $point = $request->input('point');
        $description = $request->input('description');
        
        foreach ($name as $key => $value) {
            // pemilik berdasarkan nama yang dimasukan
            $users          = User::select('id')->where('name', $users_id[$key])->first();
            $top_category   = TopCategory::select('id','name')->where('name', $top_categories_id[$key])->first();
            $category       = Category::select('id')->where('name', $categories_id[$key])->first();

                // simpan produk
                $product = new Product();
                $product->name = $value;
                $product->users_id = $users->id;
                $product->top_categories_id = $top_category->id;
                $product->categories_id = $category->id;
                $product->price = $price[$key];
                $product->stock = $stock[$key];
                $product->weight = $weight[$key];
                $product->profit_sharing = $profit_sharing[$key];
                $product->point = $point[$key];
                $product->description = $description[$key];
                $product->slug = Str::slug($value);
                $product->save();

        }
        return redirect()->route('product.index')->with(['success' => 'Produk telah disimpan']);

    }
    

}
