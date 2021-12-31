

    <x-header title="Exam | Edit Exam " >
       
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
                        <h1 class="m-0">Edit Exam</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item "><a href="/exams">Exam</a></li>
                        <li class="breadcrumb-item active">Edit Exam</li>
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
              <form action="/exams/{{$exam->id}}" method="POST" >
                @csrf
                @method('PATCH')
                <div class="card-body row">
                  <div class="form-group col-md-4">
                    <label for="name">Exam Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="" value="{{$exam->name}}" required>
                  </div>
                  @error('name')
                  <div class="text-danger">{{$message}}</div>
                  @enderror
                
                  <div class="form-group col-md-4">
                    <label for="term">Term</label>
                    <select class="form-control" name="term" id="term" required>
                    <option value="">Select Term</option>
                    <option {{$exam->term==1?'selected':''}} value="1"> 1st</option>
                    <option {{$exam->term==2?'selected':''}} value="2"> 2nd</option>
                    <option {{$exam->term==3?'selected':''}} value="3"> 3rd</option>
                    </select>
                  </div>
                  @error('term')
                  <div class="text-danger">{{$message}}</div>
                  @enderror
                  <div class="form-group col-md-4">
                  <label for="session">Session</label>
                   <select class="form-control" name="session" id="session" required>
                     <option value="">Select Session</option>
                     @foreach ($sessions as $session)
                        <option {{$session->id==$exam->session_id?'selected':''}} 
                            value="{{$session->id}}"> {{$session->start.'/'.$session->end}} 
                        </option>   
                     @endforeach
                   </select>
                  </div>
                  @error('session')
                  <div class="text-danger">{{$message}}</div>
                  @enderror
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update Exam</button>
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
 