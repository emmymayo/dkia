<?php

namespace App\Services ;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MultiDatabaseHandler{

    public function setWorkingDatabase($db){
        Config::set('database.connections.mysql.database',$db);
        DB::purge('mysql');
        session(['working_db'=>$db]);
        Session::save();
        //echo session('working_db');
    }

    public function getWorkingDatabase(){
       return Session::get('working_db');
    }

    public function clearWorkingDatabase(){
        Session::forget('working_db');
    }

    
}



?>