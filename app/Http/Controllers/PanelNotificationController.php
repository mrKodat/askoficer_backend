<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PanelNotificationController extends Controller
{
    //

    public function changeNotificationState(Request $request)
    {
        $id = $_GET['not_id'];
        DB::table('panel_notifications')
            ->where('id', $id)
            ->update(['seen' => true]);

        return response()->json(['success' => 'success'], 200);
    }
}
