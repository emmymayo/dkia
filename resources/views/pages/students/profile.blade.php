

    <x-header title="Student Profile | {{$profile->user->name}} " >
        
    </x-header>
    
            
            <x-nav-header />
            <x-sidebar-nav :name="$data->name" :avatar="$data->avatar"  />
            <x-sidebar-control />
            

            
            <div class="content-wrapper" style="min-height: 264px;">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 lead">Student Profile</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                        
                        <li class="breadcrumb-item active"><a href="/students/{{$profile->id}}">{{$profile->user->name}}</a></li>
                        </ol>
                    </div><!-- /.col -->
                    </div><!-- /.row -->
                    
                </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <div class="content">
                <div class="container-fluid">
                <!-- Response Errors-->
                
                @empty(!session('profile-update-success'))
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> Profile Update!</h5>
                  {{session('profile-update-success')}}
                </div>
                @endempty

                @empty(!session('profile-update-fail'))
                <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Profile Update!</h5>
                  {{session('profile-update-fail')}}
                </div>
                @endempty

                @empty(!session('photo-upload-success'))
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> Profile Picture Upload!</h5>
                  {{session('photo-upload-success')}}
                </div>
                @endempty
                @empty(!session('photo-upload-fail'))
                <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Profile Picture Upload!</h5>
                  {{session('photo-upload-fail')}}
                </div>
                @endempty

                @error('photo')
                <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <p>{{$message}}</p>
                </div>
                @enderror
                @error('name')
                <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <p>{{$message}}</p>
                </div>
                @enderror
                @error('email')
                <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <p>{{$message}}</p>
                </div>
                @enderror
                
                @empty(!session('change-password-success'))
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> Password Change!</h5>
                  {{session('change-password-success')}}
                </div>
                @endempty
                @empty(!session('change-password-fail'))
                <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Password Change!</h5>
                  {{session('change-password-fail')}}
                </div>
                @endempty

                @error('password')
                <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <p>{{$message}}</p>
                </div>
                @enderror
                @error('current_password')
                <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <p>{{$message}}</p>
                </div>
                @enderror
                
                <div class="row">
                    <div class="col-md-4">

                        <!-- Profile Image -->
                        <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center bg-gradient-primary">
                            <img class="profile-user-img img-fluid img-circle" src="/storage/{{$profile->user->avatar}}" alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">{{$profile->user->name}}  <small>({{$profile->gender}})</small></h3>

                            <p class="text-muted text-center">{{$profile->admin_no}}</p>
                            

                            <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Created</b> <a class="float-right">{{\Carbon\Carbon::parse($profile->created_at)->diffForHumans()}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Last Updated</b> <a class="float-right">{{\Carbon\Carbon::parse($profile->updated_at)->diffForHumans()}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Status</b> <a class="float-right">Account {{$profile->user->status==0?'Suspended':'Active'}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Year Admitted</b> <a class="float-right"> {{$profile->year_admitted}}</a>
                            </li>
                            
                            </ul>

                            <strong><i class="fas fa-info-circle "></i> Bio-Data</strong>

                            <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Date of Birth</b> <a class="float-right">{{$profile->dob}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>State of Origin</b> <a class="float-right">{{$profile->state->name}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Local Government Area</b> <a class="float-right"> {{$profile->lga->name}}</a>
                            </li>
                            
                            </ul>

                            <hr>

                            <strong><i class="fas fa-envelope "></i> Email</strong>

                            <p class="text-muted">
                             {{$profile->user->email}}
                            </p>

                            <hr>

                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Contact Information</strong>
                            
                            <p class="text-muted">{{$profile->phone1}}</p>
                            <p class="text-muted">{{$profile->phone2}}</p>
                            <p class="text-muted">{{$profile->address}}</p>

                            <hr>
                        </div>
                        <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>

                    
                    <div class="col-md-8">
                        <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                            <li class="nav-item active"><a class=" nav-link  " href="#edit_profile" data-toggle="tab">Edit Profile</a></li>
                            <li class="nav-item"><a class="nav-link " href="#upload_picture" data-toggle="tab">Upload Picture</a></li>
                            <li class="nav-item"><a class="nav-link " href="#change_password" data-toggle="tab">Change Password</a></li>
                            @can('admin-only')
                            <li class="nav-item"><a class="nav-link " href="#set_class" data-toggle="tab">Set Class</a></li>
                            @endcan
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                            
                           
                            <div class="tab-pane" id="edit_profile">
                                <form class="form-horizontal" action="/students/{{$profile->id}}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                    <input required type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{$profile->user->name}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                    <input required type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{$profile->user->email}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="admin_no" class="col-sm-2 col-form-label">Admission No/Code</label>
                                    <div class="col-sm-10">
                                    <input  type="text" class="form-control" id="admin_no" name="admin_no" placeholder="Admission No." value="{{$profile->admin_no}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="year_admitted" class="col-sm-2 col-form-label">Year of Admission</label>
                                    <div class="col-sm-10">
                                    <input  type="text" class="form-control" id="year_admitted" name="year_admitted" placeholder="Year of Admission" value="{{$profile->year_admitted}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="gender" class="col-sm-2 col-form-label">Gender</label>
                                    <div class="col-sm-10">
                                        <select name="gender" id="gender" class="form-control" required ">
                                            
                                            <option value="male" {{$profile->gender=="male" ?"selected":""}}  >Male</option>
                                            <option value="female" {{$profile->gender=="female" ?"selected":""}}>Female</option>
                                        
                                        </select>
                                    </div>
                                </div>

                             
                                <div class="form-group row">
                                    <label for="dob" class="col-sm-2 col-form-label">Date of Birth</label>
                                    <div class="col-sm-10">
                                    <input type="date" class="form-control" id="dob" name="dob" 
                                             value="{{$profile->dob}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="phone1" class="col-sm-2 col-form-label">Phone</label>
                                    <div class="col-sm-10">
                                    <input type="text" class="form-control" id="phone1" name="phone1" 
                                            placeholder="Phone (Optional)" value="{{$profile->phone1}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="phone2" class="col-sm-2 col-form-label">Phone 2</label>
                                    <div class="col-sm-10">
                                    <input type="text" class="form-control" id="phone2" name="phone2" 
                                            placeholder="Phone 2 (Optional)" value="{{$profile->phone2}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="address" class="col-sm-2 col-form-label">Contact Address</label>
                                    <div class="col-sm-10">
                                    <input type="text" class="form-control" id="address" name="address" 
                                            placeholder="Contact Address (Optional)" value="{{$profile->address}}">
                                    </div>
                                </div>
                                    <input type="hidden" name="old_state_id" value="{{$profile->state_id}}">
                                    <input type="hidden" name="old_lga_id" value="{{$profile->lga_id}}">
                                
                                    <livewire:state-lga />
                                
                                
                             
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                    <button type="submit" class="btn btn-danger">Update</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->

                            <div id="upload_picture" class="tab-pane">
                                <form action="/users/{{$profile->user->id}}/upload-photo" method="POST" enctype="multipart/form-data" >
                                @csrf
                                <div class="form-group">
                                    <label for="avatar">Profile Picture (1MB max, JPEG or PNG.)</label>
                                    <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" accept="image/*"
                                            id="photo" name="photo" required capture="environment"
                                            onchange="document.getElementById('img_preview').src = window.URL.createObjectURL(this.files[0])">
                                        <label class="custom-file-label" for="photo">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <button class="input-group-text" type="submit" >Upload</button>
                                    </div>
                                    </div>
                                    <div class="input-group">
                                        
                                        <img id="img_preview" alt="" height="100" width="100">
                                    </div>
                                </div>
                                </form>
                            </div>
                            <!--Change Password Tab -->
                            <div id="change_password" class="tab-pane">
                                <form action="/users/{{$profile->user->id}}/change-password" method="POST"  >
                                @csrf
                                @method('PATCH')
                                <div class="form-group row">
                                    <label for="current_password" class="col-sm-2 col-form-label">Current Password</label>
                                    <div class="col-sm-10">
                                    <input required type="password" class="form-control" id="current_password" name="current_password" placeholder="Current Password" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password" class="col-sm-2 col-form-label">New Password</label>
                                    <div class="col-sm-10">
                                    <input required type="password" class="form-control" id="password" name="password" placeholder="New Password" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password_confirmation" class="col-sm-2 col-form-label">Confirm Password</label>
                                    <div class="col-sm-10">
                                    <input required type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                    <button type="submit" class="btn btn-danger">Change Password</button>
                                    </div>
                                </div>
                                
                                </form>
                            </div>
                            @can('admin-only')

                            <div id="set_class" class="tab-pane">

                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Session</th>
                                            <th>Section</th>
                                            <th>...</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($student_sections as $student_section )
                                        <tr>
                                            <td>{{$loop->index+1}}</td>
                                            <td>{{$student_section->start.'/'.$student_section->end}}</td>
                                            <td> 
                                            @php
                                                $student_class= App\Models\Classes::find($student_section->classes_id);

                                            @endphp
                                            {{$student_class->name.' - '.$student_section->name}}
                                            </td>
                                            <td>
                                            
                                            <form action="/studentsectionsessions/{{$student_section->sss_id}}" method="post" 
                                                onsubmit="return confirm('Are you sure you want to remove student class record?');">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="id" value="{{$student_section->sss_id}}">
                                                <input type="hidden" name="student_id" value="{{$profile->id}}">
                                                <button class="btn btn-danger" type="submit"><i class="fas fa-trash"></i></button>
                                            </form>
                                            
                                            </td>
                                        </tr>
                                        
                                    @endforeach
                                    </tbody>
                                </table>
                                <form action="/students/{{$profile->id}}/set-class" method="POST"  >
                                @csrf
                                
                                
                                <hr>
                                @error('session_id')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                                @error('section_id')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                                <div class="form-group">
                                    <livewire:class-section />
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="session_id">Session</label>
                                        <select  class="form-control"  name="session_id" required >
                                                <option value="">Select Session</option>
                                            @foreach ( $sessions as $session )
                                                <option {{$current_session_id == $session->id?'selected':''}} value="{{$session->id}}">{{$session->start.'-'.$session->end}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary"> Set Class</button>
                                    </div>
                                
                                </form>
                            </div>
                            @endcan

                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                   
                   
                    <!-- /.col -->
                  
                    
                </div><!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
        
            <x-footer motto="" >
            <script src="/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
                <script>
                    $(function () {
                    bsCustomFileInput.init();
                    });
                </script>
            </x-footer>
        </div>
