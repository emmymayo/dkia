<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExamBroadsheetController extends Controller
{
    public function index(){
        return view('pages.exams.broadsheet.index');
    }
}
