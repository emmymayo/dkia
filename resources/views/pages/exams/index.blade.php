
    <x-header title="Exams " >
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
                        <h1 class="m-0">Exams</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="/exams">Exams</a></li>
                        </ol>
                    </div><!-- /.col -->
                    </div><!-- /.row -->
                    
                </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <div class="content">
                <div class="container-fluid">
                
                    
                @if(session('action-success'))
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> Done!</h5>
                  {{session('action-success')}}
                </div>
                @endif

                @if(session('action-fail'))
                <div class="alert alert-info alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-info"></i> Error!</h5>
                  {{session('action-fail')}}
                </div>
                @endif

                

                @error('name')
                  <p class="text-danger">{{$message}}</p>
                @enderror

                @error('term')
                  <p class="text-danger">{{$message}}</p>
                @enderror

                @error('session')
                  <p class="text-danger">{{$message}}</p>
                @enderror

              

                <div class="card card-default card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#exam_list" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Exams</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#add_exam" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">
                    <i class="fas fa-plus"></i> Add Exam</a>
                  </li>
                 
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade active show" id="exam_list" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                        <table class="table table-hover small table-responsive-md" id="exam_list_table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Term</th>
                                    <th>Session</th>
                                    <th>Published</th>
                                
                                    <th>...</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($exams as $exam)
                                <tr>
                                    <td>{{$loop->index+1}}</td>
                                    <td>{{$exam->name}}</td>
                                    <td>{{$exam->term}}</td>
                                    <td>{{$exam->session->start.'/'.$exam->session->end}}</td>
                                    <td class="{{$exam->published==0?'text-warning':'text-success'}} font-weight-bold">
                                    {{$exam->published==0?'Pending':'Published'}}
                                    </td>
                                   
                                    <td>
                                        <div class="btn-group">
                                        <button type="button" class="btn btn-success" ><i class="fas fa-stream"></i> </button>
                                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu" >
                                        
                                        <a href="/exams/{{$exam->id}}/edit" class="dropdown-item"><i class="fas fa-edit"></i> Edit</a>
                                        <a href="/exams/{{$exam->id}}/publish" class="dropdown-item"><i class="fas fa-toggle-on"></i> Toggle Publish</a>
                                       
                                        <div class="dropdown-divider"></div>
                                        <form action="/exams/{{$exam->id}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                                @csrf 
                                                @method('DELETE')
                                              
                                                <button class="dropdown-item text-danger" type="submit"><i class="fas fa-trash"></i> Delete</button>
                                        </form>
                                        
                                        </div>
                                        </div>
                                    </td>
                                   
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                  </div>
                  <div class="tab-pane fade" id="add_exam" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                  
                  <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="/exams" method="POST">
                @csrf
                <div class="card-body row">
                  <div class="form-group col-md-4">
                    <label for="name">Exam Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="E.g First Term 2021 Examination" required>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="term">Select Exam Term</label>
                    <select class="form-control" name="term" id="term" required>
                        <option value=""></option>
                        <option value="1">1st</option>
                        <option value="2">2nd</option>
                        <option value="3">3rd</option>
                    </select>
                  </div>
                  <div class="form-group col-md-4">
                  <label for="session">Exam Session</label>
                   <select class="form-control" name="session" id="session" required>
                     <option value="">Select Session</option>
                     @foreach ($sessions as $session)
                        <option value="{{$session->id}}"> {{$session->start.'/'.$session->end}} </option>
                         
                     @endforeach
                   </select>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Add Exam</button>
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
 