<div>
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
                                <th>Registered Subjects</th>
                                <th>...</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        
                            @foreach ($students as $student )
                            
                            <tr>
                            <td wire:key="{{$loop->index}}">{{$loop->index+1}}</td>
                            <td>{{$student->name}}</td>
                            <td><img src="/storage/{{$student->avatar}}" alt="Avatar" height="60" width="80"></td>
                            <td>
                                
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success" ><i class="fas fa-stream"></i> </button>
                                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu" role="menu" style="">
                                    
                                    <a href="#" class="dropdown-item" 
                                    wire:click="initRegistrationModal({{$student->student_id}})">
                                       <i class="fa fa-edit"></i> Register Subjects
                                    </a>
                                   


                                    <a wire:click.prevent="resetStudentPassword({{$student->user_id}})" role="button" class="dropdown-item" href="#"><i class="fas fa-lock"></i> Reset Password</a>
                                    <a wire:click.prevent="toggleStudentStatus({{$student->user_id}})" role="button" class="dropdown-item" href="#"><i class="fas fa-toggle-on"></i> Change Status</a>
                                    <div class="dropdown-divider"></div>
                                    
                                    
                                    </div>
                                </div>
                            </td>
                            
                            </tr>   
                            
                            
                              
                            @endforeach
                        
                        </tbody>
</table>



@endif


<div class="modal fade" id="exam-registration-modal">
        <div class="modal-dialog modal-lg">
        @if($modal_initialized)
          <div class="modal-content">
            <div class="modal-header">
            
              <h4 class="modal-title">Subject Registration For {{$exam->name}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <img src="/storage/{{$selected_student->user->avatar}}" height="100px", width="80px"  alt="">
            
            <h5>{{$selected_student->user->name}}</h5>
            <span wire:loading wire:target="syncSubjects"> Please Wait  </span><i wire:loading wire:target="syncSubjects" class="fas fa-spinner fa-spin"></i>
            @if ($registered_subjects)
              {{$registered_subjects->contains('subject_id', 1)}}
            @endif

            @if ($registered_subjects)
                          {{ $registered_subjects->contains('subject_id', 1)
                                                    ?'checked'
                                                    :'unchecked'}} 
            @endif
              <form>
                <div class="form-group row">
              @foreach ($subjects as $subject )
                  
                    <div class="form-check col-md-6">
                          <input class="form-check-input" type="checkbox" 
                          
                         
                          wire:model="selected_subjects" id="subjects" value="{{$subject->id}}">
                          <label class="form-check-label">
                          {{$subject->name}} 
                          </label>
                    </div>
                  
              @endforeach
                </div>
              
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" >Save</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
          @endif
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->


</div>
