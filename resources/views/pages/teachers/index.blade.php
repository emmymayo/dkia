

    <x-header title="Teachers " >
         <!-- DataTables -->
        <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
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
                        <h1 class="m-0 lead">Teachers</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="/teachers">Teachers</a></li>
                        </ol>
                    </div><!-- /.col -->
                    </div><!-- /.row -->
                    
                </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <div class="content">
                <div class="container-fluid">
                <div> <a href="/teachers/create" class="btn btn-app bg-blue "><i class="fas fa-user-plus"></i> Add Teacher</a></div>
                <br>
                    
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

                @empty(!session('user-delete-success'))
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> Teacher Removed</h5>
                  {{session('user-delete-success')}}
                </div>
                @endempty

                @empty(!session('user-delete-fail'))
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Error!</h5>
                  {{session('user-delete-fail')}}
                </div>
                @endempty
                
                    <table id="teacher_table" class="table table-hover small table-responsive">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>...</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        
                            @foreach ($teachers as $teacher )
                            <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>{{$teacher->user->name}}</td>
                            <td><img src="/storage/{{$teacher->user->avatar}}" class="rounded-circle" alt="Avatar" height="60" width="80"></td>
                            <td>{{$teacher->user->email}}</td>
                            <td>{{$teacher->phone}}</td>
                            <td>{{$teacher->user->status==1? 'Active':'Suspended'}}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success" ><i class="fas fa-stream"></i> </button>
                                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu" role="menu" >
                                    <a class="dropdown-item" href="/teachers/{{$teacher->id}}"><i class="fas fa-eye"></i> Profile</a>
                                    
                                    <a class="dropdown-item" href="/users/{{$teacher->user->id}}/reset-password"><i class="fas fa-lock"></i> Reset Password</a>
                                    <a class="dropdown-item" href="/users/{{$teacher->user->id}}/toggle-status"><i class="fas fa-toggle-on"></i> Change Status</a>
                                    <div class="dropdown-divider"></div>
                                    <form action="/teachers/{{$teacher->id}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                         @csrf 
                                         @method('DELETE')
                                        <button class="dropdown-item" type="submit"><i class="fas fa-trash"></i> Delete</button>
                                    </form>
                                    
                                    </div>
                                </div>
                            </td>
                            </tr>    
                                
                            @endforeach
                        
                        </tbody>
                    </table>
                  
                    
                </div><!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
        
            <x-footer motto="" >
            <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
            <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
            <script src="/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
            <script src="/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
            <script src="/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
            <script src="/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
            <script src="/plugins/jszip/jszip.min.js"></script>
            <script src="/plugins/pdfmake/pdfmake.min.js"></script>
            <script src="/plugins/pdfmake/vfs_fonts.js"></script>
            <script src="/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
            <script src="/plugins/datatables-buttons/js/buttons.print.min.js"></script>
            <script src="/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
            </x-footer>
        </div>
  