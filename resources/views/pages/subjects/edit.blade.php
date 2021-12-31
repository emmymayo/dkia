

    <x-header title="Subjects | Edit Subject " >
       
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
                        <h1 class="m-0 lead">Edit Subject</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item "><a href="/sections">Subject</a></li>
                        <li class="breadcrumb-item active"><a href="/subjects/{{$subject->id}}/edit">Edit Subject</a></li>
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
              <form action="/subjects/{{$subject->id}}" method="POST" >
                @csrf
                @method('PATCH')
                <div class="card-body row">
                  <div class="form-group col-md-4">
                    <label for="name">Subject Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="" value="{{$subject->name}}" required>
                  </div>
                  @error('name')
                  <div class="text-danger">{{$message}}</div>
                @enderror
                  

                <div class="form-group col-md-4">
                    <label for="short_name">Short Name </label>
                    <input type="text" class="form-control" id="short_name" name="short_name" placeholder="Maths, Eng, CRS" value="{{$subject->short_name}}" >
                  </div>
                  @error('short_name')
                  <div class="text-danger">{{$message}}</div>
                @enderror
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update Subject</button>
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
  