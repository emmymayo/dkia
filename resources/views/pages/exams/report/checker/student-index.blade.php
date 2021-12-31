
    <x-header title="Check Report " >
  
         <!-- DataTables -->
        
    </x-header>
    
            
            <x-nav-header />
            <x-sidebar-nav  />
            <x-sidebar-control />
           

            
            <div class="content-wrapper" style="min-height: 264px;">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 lead">Check Report</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="/exams/report/checker/student">Check Report</a></li>
                        </ol>
                    </div><!-- /.col -->
                    </div><!-- /.row -->
                    
                </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <div class="content">
                <div class="container-fluid">
                    
                    <form action="/exams/report" target="_blank" method="post" class="mx-auto mx-md-5 p-md-5 my-3">
                    @if (session('action-fail'))
                        <div class="alert alert-danger">{{session('action-fail')}}</div>
                    @endif
                    @if (session('action-success'))
                        <div class="alert alert-success">{{session('action-success')}}</div>
                    @endif
                        @csrf
                        <input type="hidden" name="student_id" value="{{$student_id}}">
                        <div class="form-group p-md-3 ">
                            <label for="">Select Examination</label>
                            <select name="exam_id" id="" class="form-control" required>
                                <option value="">---Select Exam---</option>
                                @foreach ($exams as $exam )
                                    <option value="{{$exam->id}}">{{$exam->name}}</option>
                                @endforeach
                            </select>

                        </div>
                        
                        @if ($exam_locked)
                            <div class="form-group p-md-3">
                                <label for="pin">Pin</label>
                                <input class="form-control" type="password" name="pin" id="pin" required>
                            
                            </div>
                            @error('pin')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        @endif
                        <div class="p-md-3">
                            <button class="btn btn-success" type="submit">Check Report</button>
                        </div>
                    
                    </form>
                
                    
                </div><!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
        
            <x-footer motto="" >
           
            
            

            </x-footer>