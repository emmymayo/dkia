<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mark;
use App\Http\Resources\StudentReportResource as MarkResource;

class MarkController extends Controller
{
    public function getMarks(){

        $marks = Mark::query()
                    ->when(request()->input('exam_id')!=null,
                        function($query){
                            $query->where('exam_id',request()->input('exam_id'));
                        }
                    )->when(request()->input('student_id')!=null,
                        function($query){
                            $query->where('student_id',request()->input('student_id'));
                        }
                    )->when(request()->input('section_id')!=null,
                        function($query){
                            $query->where('section_id',request()->input('section_id'));
                        }
                    )->when(request()->input('subject_id')!=null,
                        function($query){
                            $query->where('subject_id',request()->input('subject_id'));
                        }
                    )->when(request()->input('order')!=null,
                        function($query){
                            $query->orderBy(request()->input('order'). request()->input('direction','desc'));
                        }
                    )->get();
        $marks = MarkResource::collection($marks);
        return response()->json($marks);
    }
}
