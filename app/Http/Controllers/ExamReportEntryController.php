<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mark;

class ExamReportEntryController extends Controller
{
    public function index(){

        return view('pages.exams.report.entry');
    }
    public function viewEntries(){

        return view('pages.exams.report.entry-view');
    }

    public function update(Request $request,$mark_id){
        $request->validate([
            'cass1' =>  ['nullable','numeric','max:'.config('settings.cass1.max')],
            'cass2' =>  ['nullable','numeric','max:'.config('settings.cass2.max')],
            'cass3' =>  ['nullable','numeric','max:'.config('settings.cass3.max')],
            'cass4' =>  ['nullable','numeric','max:'.config('settings.cass4.max')],
            'tass' =>  ['nullable','numeric','max:'.config('settings.tass.max')],
        ]);
       // return response()->json(['message'=>$request->input('cass2')],201);
       //set request value and add 0 for columns not available
        $mark = Mark::find($mark_id);
        $mark->cass1 = $request->input('cass1',0);
        $mark->cass2 = $request->input('cass2',0);
        $mark->cass3 = $request->input('cass3',0);
        $mark->cass4 = $request->input('cass4',0);
        $mark->tass = $request->input('tass');
        if($mark->save()){
            return response()->json(['message'=>'success'],201);
        }
        return response()->json(['message'=>'failed']);

    }
}
