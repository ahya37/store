<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TopCategory;
use App\Category;

class CategoryController extends Controller
{
    public function topCategories(Request $request)
    {
        return TopCategory::select('id','name')->get();
    }

    public function categories(Request $request, $top_categories_id)
    {
        return Category::select('id','name')->where('top_categories_id', $top_categories_id)->get();
    }
}
