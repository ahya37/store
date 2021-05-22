<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QueryBuilder\Report;

class ReportController extends Controller
{
    public function index()
    {
        // get data user / pemilik toko / hanya pemilik yang produknya terjual saja
        $model  = new Report;
        $report = $model->getReportTransactionsAdmin();
        $globalFunction = app('GlobalFunction');

        return view('pages.admin.report.index', compact('report','model','globalFunction'));
    }
}
