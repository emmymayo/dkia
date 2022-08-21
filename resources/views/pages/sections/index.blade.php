

    <x-header title="Sections " >
         <!-- DataTables -->
        <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    </x-header>
   
            
            <x-nav-header />
            <x-sidebar-nav   />
            <x-sidebar-control />
           

            
            <div class="content-wrapper" style="min-height: 264px;">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Sections</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="/sections">Sections</a></li>
                        </ol>
                    </div><!-- /.col -->
                    </div><!-- /.row -->
                    
                </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <div class="content">
                <div class="container-fluid">
                
                    
                @empty(!session('section-added-success'))
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> Done!</h5>
                  {{session('section-added-success')}}
                </div>
                @endempty

                @empty(!session('section-deleted-success'))
                <div class="alert alert-info alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-info"></i> Done!</h5>
                  {{session('section-deleted-success')}}
                </div>
                @endempty

                @empty(!session('section-updated-success'))
                <div class="alert alert-info alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-info"></i> Done!</h5>
                  {{session('section-updated-success')}}
                </div>
                @endempty

                @error('name')
                  <p class="text-danger">{{$message}}</p>
                @enderror

                @error('class')
                  <p class="text-danger">{{$message}}</p>
                @enderror

              

                <div class="card card-default card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#section_list" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Sections</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#add_section" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">
                    <i class="fas fa-plus"></i> Add Section</a>
                  </li>
                 
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade active show" id="section_list" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                        <table class="table table-hover small table-responsive-md" id="section_list_table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Class</th>
                                    <th>Section </th>
                                    <th>...</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sections as $section)
                                <tr>
                                    <td>{{$loop->index+1}}</td>
                                    <td>{{$section->classes->name}}</td>
                                    <td>{{$section->name}}</td>
                                    <td>
                                        <div class="btn-group">
                                        <button type="button" class="btn btn-success" ><i class="fas fa-stream"></i> </button>
                                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu" >
                                        
                                        <a href="/sections/{{$section->id}}/edit" class="dropdown-item"><i class="fas fa-edit"></i> Edit</a>
                                        <a href="/sections/{{$section->id}}/import-students" class="dropdown-item"><i class="fas fa-upload"></i> Import Students</a>
                                        <div class="dropdown-divider"></div>
                                        <form action="/sections/{{$section->id}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?');">
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
                  </div>
                  <div class="tab-pane fade" id="add_section" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                  
                  <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"></h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="/sections" method="POST">
                            @csrf
                            <div class="card-body row">
                            <div class="form-group col-md-4">
                                <label for="name">Section Name</label>
                                <input required type="text" class="form-control" id="name" name="name" placeholder="">
                            </div>
                            <div class="form-group col-md-4">
                            <label for="class_type_id">Class</label>
                            <select class="form-control" name="section_class" id="section_class" required>
                                <option value="">Select Class</option>
                                @foreach ($classes as $each_class)
                                    <option value="{{$each_class->id}}"> {{$each_class->name}} </option>
                                    
                                @endforeach
                            </select>
                            </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Add Section</button>
                            </div>
                        </form>
                  </div>

                  </div>
                  
                </div>
              </div>
              <!-- /.card -->
            </div>
                
                   
                    
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
   