<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\TopCategory;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use File;
use App\Http\Requests\Admin\TopCategoryRequest;

class TopCategoryController extends Controller
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
            $query = TopCategory::query();

            return Datatables::of($query)
                ->addColumn('action', function($item){
                    return '
                        <div class="btn-group">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle mr-1 mb-1" type="button" data-toggle="dropdown">Aksi</button>
                                <div class="dropdown-menu">
                                     <a class="dropdown-item" href="' .route('topcategory.edit', $item->id). '">
                                        Edit
                                     </a>
                                     <form action="'. route('topcategory.destroy', $item->id) .'" method="POST">
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
                ->editColumn('photo', function($item){
                    return $item->photo  ? '<img src="'. Storage::url($item->photo) .'" style="max-height: 40px;" />' : '';
                })
                ->rawColumns(['action','photo'])
                ->make();
        }
        return view('pages.admin.topcategory.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.topcategory.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TopCategoryRequest $request)
    {
        $data = $request->all();

        $data['slug']  = Str::slug($request->name);
        $data['photo'] = $request->file('photo')->store('assets/topcategory', 'public');

        TopCategory::create($data);

        return redirect()->route('topcategory.index')->with(['success' => 'Top Kategori telah ditambahkan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = TopCategory::findOrFail($id);

        return view('pages.admin.topcategory.edit', ['item' => $item]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TopCategoryRequest $request, $id)
    {
        $data = $request->all();

        $data['slug']  = Str::slug($request->name);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('assets/topcategory', 'public');
        }

        $item = TopCategory::findOrFail($id);

        $item->update($data);

        return redirect()->route('topcategory.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = TopCategory::findOrFail($id);        
        $item->delete();

        return redirect()->route('topcategory.index');
    }
}
