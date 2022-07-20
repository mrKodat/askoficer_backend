<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    //
    public function allreports()
    {
        $allreports = Report::all();
        return view('reports.all-reports', ['allreports' => $allreports]);
    }

    public function questionreports()
    {
        $questionreports = Report::where('type', '=', 'Question')->get();
        return view('reports.question-reports', ['questionreports' => $questionreports]);
    }

    public function answerreports()
    {
        $answerreports = Report::where('type', '=', 'Answer')->get();
        return view('reports.answer-reports', ['answerreports' => $answerreports]);
    }

    public function reportdelete($id)
    {
        $report = Report::find($id);
        $report->delete();
        return back()->with('status', 'Report deleted successfully');
    }
}
