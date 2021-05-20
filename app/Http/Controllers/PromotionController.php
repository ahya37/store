<?php

namespace App\Http\Controllers;

use App\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        $items = Promotion::with(['product.galleries'])->get();
        return view('pages.promotions', compact('items'));
    }
}
