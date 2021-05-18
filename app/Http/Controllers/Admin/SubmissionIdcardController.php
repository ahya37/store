<?php

namespace App\Http\Controllers\Admin;

use App\IdCard;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class SubmissionIdcardController extends Controller
{
    public function index()
    {
        if (request()->ajax()) 
        {
            $query = IdCard::with(['user'])->where('status',0);

            return Datatables::of($query)
                ->addColumn('action', function($item){
                    return '
                        <div class="btn-group">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle mr-1 mb-1" type="button" data-toggle="dropdown">Aksi</button>
                                <div class="dropdown-menu">
                                    <form action="'. route('submissionidcard.update', $item->id) .'" method="POST">
                                         '. method_field('PUT') . csrf_field() .'
                                         <button type="submit" class="dropdown-item">
                                            Setujui
                                         </button>
                                     </form>
                                     
                                     <form action="'. route('submissionidcard.destroy', $item->id) .'" method="POST">
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
                ->editColumn('file', function($item){
                    return $item->file  ? '<img src="'. Storage::url($item->file) .'" style="max-height: 40px;" />' : '';
                })
                ->rawColumns(['action','file'])
                ->make();
        }
        return view('pages.admin.submission-idcard.index');
    }

    public function update(Request $request, $id)
    {
        $data['status'] = 1;

        $item = IdCard::findOrFail($id);

        $item->update($data);

        return redirect()->route('submissionidcard.index')->with(['success' => 'KTP telah disetujui']);

    }

    public function destroy($id)
    {
        $item = IdCard::findOrFail($id);
        $item->delete();

        return redirect()->route('submissionidcard.index');
    }
}
