<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Category;
use App\IdCard;
use Auth;
use File;

class DashboardSettingController extends Controller
{
    public function store()
    {
        $user   = Auth::user();
        $idcard = IdCard::with(['user'])->where('users_id', Auth::user()->id)->first();
        return view('pages.dashboard-settings', compact('user','idcard'));
    }

    public function account()
    {
        $user = Auth::user();
        return view('pages.dashboard-account', compact('user'));
    }

    public function update(Request $request, $redirect)
    {
        $data = $request->all();
        $item = Auth::user();

        $item->update($data);

        return redirect()->route($redirect);
    }

    public function idCardStore(Request $request)
    {
        $data = $request->all();
        $data['file'] = $request->file('file')->store('assets/idCard', 'public');
        $data['users_id'] = $request->users_id;

        IdCard::create($data);

        return redirect()->route('dashboard-settings-store', $request->products_id);
    }

    public function deleteIdCard(Request $request, $id)
    {
        $item = IdCard::findorFail($id);
        // delete file 
        File::delete(storage_path('app/public/'.$item->file));

        // delete data 
        $item->delete();

        return redirect()->route('dashboard-settings-store');
    }

}
