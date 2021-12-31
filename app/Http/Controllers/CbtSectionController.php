<?php

namespace App\Http\Controllers;

use App\Models\CbtSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CbtSectionController extends Controller
{
    public function index(){
        
        if(request()->expectsJson()){
            $cbt_sections = $this->getCbtSections();
            return response()->json($cbt_sections);
        }
        return ;
    }

    public function show($id)
    {
        $cbt_section = CbtSection::find($id);
        if(request()->expectsJson()){
            return response()->json($cbt_section);
        }
        return;
    }
    public function toggle(Request $request){
        //Authorize user
        Gate::authorize('admin-and-teacher-only'); 
        $data = $request->validate([
            'section_id' => 'required|exists:sections,id',
            'cbt_id' => 'required|exists:cbts,id',
        ]);

        //Fetch cbt section 
        $cbt_section = CbtSection::firstWhere([
            'cbt_id' => $data['cbt_id'],
            'section_id' => $data['section_id']
        ]);

        //If it exists delete
        // else create new
        if($cbt_section!=null){
            $cbt_section->delete();
        }else{
            
            $cbt_section = new CbtSection;
            $cbt_section->section_id = $data['section_id'];
            $cbt_section->cbt_id = $data['cbt_id'];
            $cbt_section->save();
        }


        if($request->expectsJson()){
            return response()->json([
                'message' => 'success'
            ],201);
        }
        return;
    }

    private function getCbtSections(){
        //Get Eloquemt Query builder after applying filters and ordering
        $cbt_section_query = CbtSection::query()
                    ->when(request()->has('section_id'),
                        function($query){
                            $query->where('section_id',request()->input('section_id'));
                        }
                    )->when(request()->has('cbt_id'),
                        function($query){
                            $query->where('cbt_id',request()->input('cbt_id'));
                        }
                    )->when(request()->has('order'), 
                        function($query){
                            $query->orderBy(request()->input('order'),request()->input('direction','desc'));
                        }
                    )->when(!request()->has('order'), 
                        function($query){
                            $query->latest();
                        }
                    );
    
        //Whenever url query contains page then paginate, else return the collection
        $cbt_sections = request()->has('page') ? $cbt_section_query->paginate() : $cbt_section_query->get();
        return $cbt_sections;
    }
}
