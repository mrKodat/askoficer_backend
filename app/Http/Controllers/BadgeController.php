<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use Illuminate\Http\Request;

class BadgeController extends Controller
{
    public function index(Badge $badges)
    {
        return view('badges.badges-index', ['badges' => $badges->orderBy('id', 'DESC')->get()]);
    }

    public function badgeedit(Request $request, $id)
    {
        $badge = Badge::findOrFail($id);
        return view('badges.badge-edit')->with('badge', $badge);
    }

    public function badgeupdate(Request $request, $id)
    {
        $badge = Badge::find($id);
        $badge->name = $request->input('name');
        $badge->from = $request->input('from');
        $badge->to = $request->input('to');
        $badge->description = $request->input('description');
        $badge->color = $request->input('color');
        $badge->save();

        return redirect('/badges')->with('status', 'badge updated successfully');
    }

    public function badgedelete($id)
    {
        $badge = Badge::findOrFail($id);
        $badge->delete();

        return redirect('/badges')->with('status', 'badge deleted successfully');
    }

    public function badgeadd(Request $request)
    {
        $badge = new Badge;
        $badge->name = $request->input('name');
        $badge->from = $request->input('from');
        $badge->to = $request->input('to');
        $badge->description = $request->input('description');
        $badge->color = $request->input('color');
        $badge->save();
        
        return redirect('/badges')->with('status', 'badge added successfully');
    }
}
