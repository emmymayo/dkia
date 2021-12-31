

    <x-header title="Sections | Edit Section " >
       
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
                        <h1 class="m-0">Edit Section</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item "><a href="/sections">Sections</a></li>
                        <li class="breadcrumb-item active"><a href="/sections/{{$section->id}}/edit">Edit Section</a></li>
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
              <form action="/sections/{{$section->id}}" method="POST" >
                @csrf
                @method('PATCH')
                <div class="card-body row">
                  <div class="form-group col-md-4">
                    <label for="name">Section Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="" value="{{$section->name}}" required>
                  </div>
                  @error('name')
                  <div class="text-danger">{{$message}}</div>
                @enderror
                  <div class="form-group col-md-4">
                  <label for="class_type_id">Class</label>
                   <select class="form-control" name="section_class" id="section_class" required>
                     <option value="">Select Category</option>
                     @foreach ($classes as $each_class)
                        <option {{$section->classes_id==$each_class->id?'selected':''}} value="{{$each_class->id}}"> {{$each_class->name}} </option>
                         
                     @endforeach
                   </select>
                  </div>
                  @error('section_class')
                  <div class="text-danger">{{$message}}</div>
                @enderror
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update Section</button>
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
   