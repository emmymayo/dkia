

    <x-header title="Classes " >
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
                        <h1 class="m-0">Classes</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="/classes">Classes</a></li>
                        </ol>
                    </div><!-- /.col -->
                    </div><!-- /.row -->
                    
                </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <div class="content">
                <div class="container-fluid">
                
                    
                @empty(!session('class-added-success'))
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> Done!</h5>
                  {{session('class-added-success')}}
                </div>
                @endempty

                @empty(!session('class-deleted-success'))
                <div class="alert alert-info alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-info"></i> Done!</h5>
                  {{session('class-deleted-success')}}
                </div>
                @endempty

                @empty(!session('class-updated-success'))
                <div class="alert alert-info alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-info"></i> Done!</h5>
                  {{session('class-updated-success')}}
                </div>
                @endempty

                @error('name')
                  <p class="text-danger">{{$message}}</p>
                @enderror

                @error('class_type_id')
                  <p class="text-danger">{{$message}}</p>
                @enderror

              

                <div class="card card-default card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#class_list" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Classes</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#add_class" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">
                    <i class="fas fa-plus"></i> Add Class</a>
                  </li>
                 
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade active show" id="class_list" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                        <table class="table table-striped table-responsive-md" id="class_list_table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Class Category</th>
                                    <th>...</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($classes as $each_class)
                                <tr>
                                    <td>{{$loop->index+1}}</td>
                                    <td>{{$each_class->name}}</td>
                                    <td>{{$each_class->classType->name}}</td>
                                    <td>
                                        <div class="btn-group">
                                        <button type="button" class="btn btn-success" ><i class="fas fa-stream"></i> </button>
                                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu" >
                                        
                                        <a href="/classes/{{$each_class->id}}/edit" class="dropdown-item"><i class="fas fa-edit"></i> Edit</a>
                                        <div class="dropdown-divider"></div>
                                        <form action="/classes/{{$each_class->id}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?');">
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
                  <div class="tab-pane fade" id="add_class" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                  
                  <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="/classes" method="POST">
                @csrf
                <div class="card-body row">
                  <div class="form-group col-md-4">
                    <label for="name1">Class Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="E.g Primary 1" required>
                  </div>
                  <div class="form-group col-md-4">
                  <label for="class_type_id">Category</label>
                   <select class="form-control" name="class_category" id="class_category" required>
                     <option value="">Select Category</option>
                     @foreach ($class_types as $class_type)
                        <option value="{{$class_type->id}}"> {{$class_type->name}} </option>
                         
                     @endforeach
                   </select>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Add Class</button>
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
