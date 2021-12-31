<div>
            @if(session()->has('student-added-success'))
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> Done!</h5>
                  {{session('student-added-success')}}
                </div>
              @endif
              @if(session()->has('student-added-fail'))
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> Done!</h5>
                  {{session('student-added-fail')}}
                </div>
              @endif
              

<div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"> <i wire:loading class="fas fa-spinner fa-spin"></i> Carefully fill the form.</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form   wire:submit.prevent="saveStudent">
              
              
              
             
              @php
                  $current_session = $settings->where('key','current.session')->first();
                  
              @endphp
                
                <div class="card-body row">
                
                
                <div class="form-group col-md-4">
                <label for="">Year of Admission </label>
                  <input class="form-control" type="text" wire:model="year_admitted"  >
                  @error('year_admitted')<span class="text-danger">{{$message}}</span>@enderror
                </div>
                  <div class="form-group col-md-4">
                    <label for="Email">Email </label>
                    <input required type="email" class="form-control" wire:model="email" placeholder="Enter email">
                    @error('email')<span class="text-danger">{{$message}}</span>@enderror
                  </div>

              <!-- 
                  <div class="form-group col-md-3">
                    <label for="password">Password</label>
                    <input required type="password" class="form-control" wire:model="password" placeholder="Password">
                   @error('password')<span class="text-danger">{{$message}}</span>@enderror
                  </div>

                  <div class="form-group col-md-3">
                    <label for="password">Confirm Password</label>
                    <input required type="password" class="form-control" wire:model="password_confirmation" placeholder="Confirm Password">
                    @error('password_confirmation')<span class="text-danger">{{$message}}</span>@enderror
                  </div>
              -->

                  <div class="form-group col-md-4">
                    <label for="name">Full Name </label>
                    <input required type="text" class="form-control" wire:model="name" placeholder="Enter your full name">
                    @error('name')<span class="text-danger">{{$message}}</span>@enderror
                  </div>

                  <div class="form-group col-md-4">
                    <label for="dob">Date of Birth </label>
                    <input type="date" class="form-control"  wire:model="dob" required>
                    @error('dob')<span class="text-danger">{{$message}}</span>@enderror
                  </div>
                  <div class="form-group col-md-4">
                    <label for="admin_no">Admission Number/Code </label>
                    <input type="text" class="form-control"  wire:model="admin_no" >
                    @error('admin_no')<span class="text-danger">{{$message}}</span>@enderror
                  </div>
                  <div class="form-group col-md-4">
                    <label for="phone1">Phone </label>
                    <input type="text" class="form-control"  wire:model="phone1" placeholder="Optional">
                    @error('phone1')<span class="text-danger">{{$message}}</span>@enderror
                  </div>
                  <div class="form-group col-md-4">
                    <label for="phone2">Phone 2 </label>
                    <input type="text" class="form-control"  wire:model="phone2" placeholder="Optional">
                    @error('phone2')<span class="text-danger">{{$message}}</span>@enderror
                  </div>
                  <div class="form-group col-md-4">
                    <label for="gender">Gender </label>
                    <select class="form-control"  wire:model="gender" required>
                        <option value=""> Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    @error('gender')<span class="text-danger">{{$message}}</span>@enderror
                  </div>

                  <div class="form-group col-md-4">
                    <label for="state">State </label>
                    <select class="form-control" wire:model="state"  wire:change="setLga">
                        <option value=""> Select State</option>
                        @foreach ($states as $state )
                        <option  value="{{$state->id}}"> {{$state->name}}</option> 
                        @endforeach
                    </select>
                    @error('state')<span class="text-danger">{{$message}}</span>@enderror
                  </div>

                  <div class="form-group col-md-4">
                    <label for="lga">LGA <i wire:loading wire:target="setLga" class="fas fa-spin fa-spinner"> </i> </label>
                    <select class="form-control" wire:model="lga"  >
                      
                      @empty ($lgas)  
                        <option value=""> Select State First</option>
                      @endempty
                      <option value=""></option>
                      @if (!empty($lgas))
                        @foreach ($lgas as $lga )
                        <option  value="{{$lga->id}}"> {{$lga->name}}</option> 
                        @endforeach
                      @endif
                    </select>
                    @error('lga')<span class="text-danger">{{$message}}</span>@enderror
                  </div>
                  
                  <div class="form-group col-md-4">
                        <label>Contact Address</label>
                        <textarea class="form-control" rows="3" name="address" placeholder="Contact Address"></textarea>
                    @error('address')<span class=" text-danger">{{$message}}</span>@enderror
                  </div>

                  <div class="col-md-4"></div>

                    <div class="col-md-4">
                    <label for="session">Session </label>
                        <select wire:model="session_id" class="form-control"   >
                                <option value="">Select Session</option>
                            @foreach ( $sessions as $session )
                                <option  value="{{$session->id}}">{{$session->start.'-'.$session->end}}</option>
                            @endforeach
                        </select>
                    </div>
                  
                    <div class="col-md-4">
                    <label for="section_class">Class  </label>
                        <select wire:model="section_class" class="form-control" wire:change="setSections"  >
                                <option value="">Select Class</option>
                            @foreach ( $all_classes as $each_class )
                                <option  value="{{$each_class->id}}">{{$each_class->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                    <label for="section">Section <i wire:loading wire:target="setSections" class="fas fa-spin fa-spinner"> </i> </label>
                        <select  id="section" class="form-control" wire:model="section_id" required>
                           <option value=""></option>
                            @if (!empty($sections))
                            @foreach ( $sections as $section )
                                <option  value="{{$section->id}}">{{$section->name}}</option>
                            @endforeach
                            @endif
                        </select>
                        
                    </div>

                  
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">
                  <i wire:loading wire:target="saveStudent" class="fas fa-spin fa-spinner"></i> Admit Student
                  </button>
                  
                </div>
              </form>
            </div>
</div>
