<?php

namespace App\Http\Controllers;

use App\Models\Point;
use App\Models\Points;
use Illuminate\Http\Request;

class PointController extends Controller
{
    public function index(Point $points)
    {
        return view('points.points-index', ['points' => $points->orderBy('id', 'ASC')->get()]);
    }

    public function pointedit(Request $request, $id)
    {
        $point = Point::findOrFail($id);
        return view('points.point-edit')->with('point', $point);
    }

    public function pointupdate(Request $request, $id)
    {
        $point = Point::find($id);
        $point->points = $request->input('points');
        $point->description = $request->input('description');
        $point->save();

        return redirect('/points')->with('status', 'Point updated successfully');
    }

    public function pointdelete($id)
    {
        $point = Point::findOrFail($id);
        $point->delete();

        return redirect('/points')->with('status', 'Point deleted successfully');
    }

    public function pointadd(Request $request)
    {
        $point = new Point;
        $point->points = $request->input('points');
        $point->description = $request->input('description');
        $point->save();
        
        return redirect('/points')->with('status', 'Point added successfully');
    }
}
