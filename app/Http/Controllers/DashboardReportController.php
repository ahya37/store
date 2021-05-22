<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QueryBuilder\Report;
use Auth;

class DashboardReportController extends Controller
{
    public function index()
    {
        $model  = new Report;
        $report = $model->getReportTransactions(Auth::id());
        $globalFunction = app('GlobalFunction');
        $no     = 1;
        return view('pages.dashboard-transactions-report', compact('report','globalFunction','no'));
    }
}
