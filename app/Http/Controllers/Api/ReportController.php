<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $report = Report::create($request->all());
        DB::table('panel_notifications')->insert(["message" => "A new report with id $report->id has been published", "url" => url('') . "/all-reports"]);
        return response()->json(["message" => "Report submitted successfully"], 201);
    }
}
