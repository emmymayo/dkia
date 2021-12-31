
<div>

                @empty(!session('password-reset-success'))
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> Password Reset!</h5>
                  {{session('password-reset-success')}}
                </div>
                @endempty

                @empty(!session('toggle-status-success'))
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> Change Status!</h5>
                  {{session('toggle-status-success')}}
                </div>
                @endempty

                @empty(!session('student-delete-success'))
                <div class="alert alert-info alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> Delete!</h5>
                  {{session('student-delete-success')}}
                </div>
                @endempty

                @empty(!session('student-delete-fail'))
                <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Delete!</h5>
                  {{session('student-delete-fail')}}
                </div>
                @endempty
                
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><i wire:loading class="fas fa-spinner fa-spin"></i> Select Section to Load Students. </h3>
    </div>
    <div class="card-body">
        
      <div class="row">
        <div class="col-md-4">
            <select wire:model="section_class" class="form-control" wire:change="setSections" wire:change="$refresh" >
                    <option value="">Select Class</option>
                @foreach ( $all_classes as $each_class )
                    <option  value="{{$each_class->id}}">{{$each_class->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select name="section" id="section" class="form-control" wire:model="section_id">
                <option value=""></option>
                @if (!empty($sections))
                @foreach ( $sections as $section )
                    <option  value="{{$section->id}}">{{$section->name}}</option>
                @endforeach
                @endif
            </select>
            
        </div>
        <button class="btn btn-primary" wire:click="loadStudents" ><i wire:loading wire:target="loadStudents" class="fas fa-spinner fa-spin"></i> Load<span wire:loading wire:target="loadStudents" >ing</span> Students</button>
      </div>
    </div>
              <!-- /.card-body -->
</div>


@if (!empty($students) OR $students!==null )
    

<table id="student_table" class="table table-striped" >
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Adm No.</th>
                                
                                <th>Status</th>
                                <th>...</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        @php
                             $student_count = 1;
                        @endphp
                            @foreach ($students as $student )
                            
                            <tr>
                            <td wire:key="{{$loop->index}}">{{$student_count}}</td>
                            <td>{{$student->name}}</td>
                            <td><img src="/storage/{{$student->avatar}}" alt="Avatar" height="60" width="80"></td>
                            <td>{{$student->admin_no}}</td>
                            
                            <td>{{$student->status==1? 'Active':'Suspended'}}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success" ><i class="fas fa-stream"></i> </button>
                                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu" role="menu" style="">
                                    <a class="dropdown-item" href="/students/{{$student->student_id}}"><i class="fas fa-eye"></i> Profile</a>
                                    
                                    <a wire:click.prevent="resetStudentPassword({{$student->user_id}})" role="button" class="dropdown-item" href="#"><i class="fas fa-lock"></i> Reset Password</a>
                                    <a wire:click.prevent="toggleStudentStatus({{$student->user_id}})" role="button" class="dropdown-item" href="#"><i class="fas fa-toggle-on"></i> Change Status</a>
                                    <div class="dropdown-divider"></div>
                                    <form  wire:submit.prevent="deleteStudent({{$student->student_id}})" onsubmit="return confirm('Are you sure you want to delete this student?');">
                                         
                                         
                                        <button class="dropdown-item" type="submit"><i class="fas fa-trash"></i> Delete</button>
                                    </form>
                                    
                                    </div>
                                </div>
                            </td>
                            </tr>   
                             
                             @php
                                 $student_count++;
                             @endphp   
                            @endforeach
                        
                        </tbody>
</table>


@endif


<script> {{$notification}} </script>
    
</div>