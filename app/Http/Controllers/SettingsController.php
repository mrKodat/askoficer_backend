<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SettingsController extends Controller
{
    public function index(Setting $settings)
    {
        $settings = Setting::all();
        return view('settings.site-info', compact('settings'));
    }

    public function appinfo()
    {
        $settings = Setting::all();
        return view('settings.app-info', compact('settings'));
    }
    
     public function webinfo()
    {
        $settings = Setting::all();
        return view('settings.web-info', compact('settings'));
    }

    public function pushnotifications()
    {
        $settings = Setting::all();
        return view('settings.push-notifications', compact('settings'));
    }

    public function saveappinfo(Request $request)
    {
        $exists = DB::table('settings')->where('id', 1)->first();

        if ($exists) {
            DB::table('settings')->update(
                [
                    'privacy_policy' => $request->input('privacy_policy'),
                    'terms_and_conditions' => $request->input('terms_and_conditions'),
                    'about_us' => $request->input('about_us'),
                    'faq' => $request->input('faq'),
                    'contact_us' => $request->input('contact_us'),
                ]
            );
        } else {
            DB::table('settings')->insert(
                [
                    'privacy_policy' => $request->input('privacy_policy'),
                    'terms_and_conditions' => $request->input('terms_and_conditions'),
                    'about_us' => $request->input('about_us'),
                    'faq' => $request->input('faq'),
                    'contact_us' => $request->input('contact_us'),
                ]
            );
        }

        return redirect('/app-info')->with('status', 'Settings updated successfully');
    }
    
    public function savewebinfo(Request $request)
    {
        $exists = DB::table('settings')->where('id', 1)->first();

        if ($exists) {
               if ($request->hasFile('favicon')) {
            if ($exists->favicon != null) {
                $oldImagePath = public_path("/uploads/settings/$exists->favicon");
                if (File::exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $favicon =  $request->file('favicon');
            $extension = $favicon->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $favicon->move('uploads/settings/', $filename);
            $exists->favicon = $filename;
        }
        
            DB::table('settings')->update(
                [
                    'web_name' => $request->input('web_name'),
                    'favicon' => $filename,
                ]
            );
        } else {
                 if ($request->hasFile('favicon')) {
            if ($exists->favicon != null) {
                $oldImagePath = public_path("/uploads/settings/$exists->favicon");
                if (File::exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $favicon =  $request->file('favicon');
            $extension = $favicon->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $favicon->move('uploads/settings/', $filename);
            $exists->favicon = $filename;
        }
        
            DB::table('settings')->insert(
                [
                    'web_name' => $request->input('web_name'),
                    'favicon' => $filename,
                ]
            );
           
        }

        return redirect('/web-info')->with('status', 'Settings updated successfully');
    }

    public function savepushnotifications(Request $request)
    {
        $exists = DB::table('settings')->where('id', 1)->first();

        if ($exists) {
            DB::table('settings')->update(
                [
                    'fcm_key' => $request->input('fcm_key'),
                ]
            );
     
        
        } else {
            DB::table('settings')->insert(
                [
                    'fcm_key' => $request->input('fcm_key'),
                ]
            );
           
        }

        return redirect('/push-notifications')->with('status', 'Settings updated successfully');
    }
}
