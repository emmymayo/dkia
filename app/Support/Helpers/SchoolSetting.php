<?php 

namespace App\Support\Helpers;

use App\Models\Setting;
use App\Models\Session;

class SchoolSetting {

    public static function getSchoolSetting($key){
        return Setting::where('key',$key)->first()->value;
    }

    public static function setSchoolSetting($key,$value=''){
        $school_setting = Setting::where('key',$key)->first();
        $school_setting->value = $value;
        return $school_setting->save();

    }

    public static function getNextSchoolSessionId(){
        $current_session = Session::find(self::getSchoolSetting('current.session'));
        
        $next_session = Session::firstWhere('start',$current_session->end);
        return $next_session->id;
    }

    	
	
	
    
}


?>