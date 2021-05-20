<?php

namespace App\Http\Controllers\API;

use App\Bank;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function banks()
    {
        return Bank::all();
    }
}
