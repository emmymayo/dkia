

    <x-header title="Classes | Edit Class " >
       
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
                        <h1 class="m-0">Edit Class</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item "><a href="/classes">Classes</a></li>
                        <li class="breadcrumb-item active"><a href="/classes/{{$the_class->id}}/edit">Edit Class</a></li>
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
              <form action="/classes/{{$the_class->id}}" method="POST" >
                @csrf
                @method('PATCH')
                <div class="card-body row">
                  <div class="form-group col-md-4">
                    <label for="name">Class Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="E.g Primary 1" value="{{$the_class->name}}" required>
                  </div>
                  @error('name')
                  <div class="text-danger">{{$message}}</div>
                @enderror
                  <div class="form-group col-md-4">
                  <label for="class_type_id">Category</label>
                   <select class="form-control" name="class_category" id="class_category" required>
                     <option value="">Select Category</option>
                     @foreach ($class_types as $class_type)
                        <option {{$the_class->class_type_id==$class_type->id?'selected':''}} value="{{$class_type->id}}"> {{$class_type->name}} </option>
                         
                     @endforeach
                   </select>
                  </div>
                  @error('class_category')
                  <div class="text-danger">{{$message}}</div>
                @enderror
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update Class</button>
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
 