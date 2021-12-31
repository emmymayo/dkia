

    <x-header title="Exam Registration | Register " >
       
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
                        <h1 class="m-0">Register Exam</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item "><a href="/exams">Exam</a></li>
                        <li class="breadcrumb-item active">Exam Registration</li>
                        </ol>
                    </div><!-- /.col -->
                    </div><!-- /.row -->
                    
                </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <div class="content">
                <div class="container-fluid">
                

                <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="/exams-registration" method="POST" >
                @csrf
                <h3>Registration For {{$exam->name}} </h3>
                
                <input type="hidden" name="exam_id" value="{{$exam->id}}" />
                <input type="hidden" name="exam_id" value="{{$exam->id}}" />
                <input type="hidden" name="exam_id" value="{{$exam->id}}" />
                <div class="card-body row">
                  <div class="form-group col-md-4">
                    <label for="name">Exam Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="" value="{{$exam->name}}" required>
                  </div>
                  @error('name')
                  <div class="text-danger">{{$message}}</div>
                  @enderror
                
                 
                 
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Register</button>
                </div>
              </form>
            </div>

              

                
                
                   
                    
                </div><!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
        
            <x-footer motto="" >
            
            </x-footer>
        </div>
   