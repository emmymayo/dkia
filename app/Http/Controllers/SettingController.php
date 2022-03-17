<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Session;
use App\Support\Helpers\SchoolSetting;


class SettingController extends Controller
{
    public function index(){
        $this->authorize('viewAny', Setting::class);
        $logo = SchoolSetting::getSchoolSetting('school.logo');
        return view('pages.settings.index',[
            'logo' => $logo
        ]);
    }

    public function getSettings(){
        
        $settings = Setting::all();
        return response()->json($settings,200);
    }

    public function getSetting($unique_key){

        $setting = Setting::firstWhere('key',$unique_key);
        return response()->json($setting,200);
    }

    public function getSessions(){
        $sessions = Session::all();
        return response()->json($sessions,200);
    }

    public function updateSetting(Request $request){
        $this->authorize('create', Setting::class);
        $request->validate([
            'key' => 'required',
            'value' => 'required'
        ]);

        $setting = Setting::firstWhere('key',$request->input('key'));
        $setting->value = $request->input('value');
        if($setting->save()){
            return response()->json(['message'=>'success'],201);
        }
        return response()->json(['message'=>'failed']);
    }
    public function uploadSchoolLogo(Request $request){
        $this->authorize('create', Setting::class);
        $request->validate([
            'photo' => 'bail|required|file|image|max:200|mimes:jpg,png'
        ]);
        if($request->file('photo')){
            
            $extension = $request->photo->extension();
            $filename = "school-logo".".".$extension;
            $path = $request->photo->storeAs('images',$filename,'public');
            SchoolSetting::setSchoolSetting('school.logo',$path);
            return back()->with('action-success','Profile Picture Updated Successfully');
        }
        return back()->with('action-fail','Something went wrong. Try Again');
    }

    public function schoolLogoIndex(){
        $logo = SchoolSetting::getSchoolSetting('school.logo');
        return view('pages.settings.school-logo',['logo' => $logo]);
    }
}
