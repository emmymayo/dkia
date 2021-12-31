<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notice;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class NoticeController extends Controller
{
    public function index(){
        
        if(request()->expectsJson()){
            return $this->getNotices();
        }
        
        return view('pages.notices.index');
    }

    public function list(){
        
        $notices = Auth::user()->role->notices;
        return view('pages.notices.list',['notices' => $notices]);
    }

    protected function getNotices(){
        //query and filter notices
        $notices = Notice::query()
                    ->when(request()->has('role_id'), function($query){
                        $query->where('role_id',request()->input('role_id'));
                    })->when(request()->has('group'), function($query){
                        $role = \App\Models\Role::firstWhere('name',request()->input('group'));
                        if($role != null){
                            $query->where('role_id',request()->input('group'));
                        } 
                    })->when(request()->has('order'), function($query){
                        $query->orderBy(request()->input('order'),request()->input('direction','desc'));
                    })->when(!request()->has('order'), function($query){
                        $query->latest();
                    })->get();

       return response()->json($notices);
    }

    public function show($id){
        $notice = Notice::find($id);
        if(request()->expectsJson()){
            return response()->json($notice);
        }
        //return authorize appropriately notice group and admins are allowed
        if(!(($notice->role_id == auth()->user()->role_id) OR (Gate::allows('admin-only')))){
            abort(403);
        }
        return view('pages.notices.show',['notice' => $notice]);
    }

    public function store(Request $request){
        Gate::authorize('admin-only');
        $data = $request->validate([
            'title' => 'required|string|max:250',
            'message' => 'required|string',
            'role_id' => 'required|exists:roles,id',
            'expires_at' => 'nullable|date'
        ]);
        $notice = new Notice();
        $notice->title = $data['title'];
        $notice->message = $data['message'];
        $notice->role_id = $data['role_id'];
            //expires in seven days if value not provided
        $notice->expires_at = isset($data['expires_at'])? $data['expires_at']
                                                        : now()->addDays(7)->format('Y-m-d'); 
        $saved = $notice->save();
        if(request()->expectsJson()){
            return $saved ? response()->json(["message"=>"success","data"=>$notice],201)
                          : response()->json(["message"=>"fail"]);
         }

         return;
    }
    public function update(Request $request, $id){
        Gate::authorize('admin-only');
        $data = $request->validate([
            'title' => 'nullable|string|max:250',
            'message' => 'nullable|string',
            'role_id' => 'nullable|exists:roles,id',
            'expires_at' => 'nullable|date'
        ]);
        $notice = Notice::find($id);
        isset($data['title']) ? $notice->title = $data['title'] : null;
        isset($data['message']) ? $notice->message = $data['message'] : null;
        isset($data['role_id']) ? $notice->role_id = $data['role_id'] : null;
        isset($data['expires_at']) ? $notice->expires_at = $data['expires_at'] : null; 
        $saved = $notice->save();
        if(request()->expectsJson()){
            return $saved ? response()->json(["message"=>"success","data"=>$notice],201)
                          : response()->json(["message"=>"fail"]);
         }

         return;
    }

    public function destroy($id){
        Gate::authorize('admin-only');
        //find and delete grade system
        $notice = Notice::find($id);
        $deleted = $notice->delete();
        if(request()->expectsJson()){
            return $deleted ? response()->json(["message"=>"success","data"=>$notice],201)
                          : response()->json(["message"=>"fail"]);
         }
         return ; 
    }

}
