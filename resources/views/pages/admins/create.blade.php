
    <x-header title="Add Admin " >
        
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
                        <h1 class="m-0 lead">Add Admin</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item "><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="/admins/create">Add Admin</a></li>
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
                <h3 class="card-title">Carefully fill the form.</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="/admins" method="POST" enctype="multipart/form-data">
              @csrf
              @method('POST')
              @empty(!session('admin-added-success'))
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> Done!</h5>
                  {{session('admin-added-success')}}
                </div>
              @endempty
              @empty(!session('admin-added-fail'))
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Error!</h5>
                  {{session('admin-added-fail')}}
                </div>
              @endempty
              @empty(!session('photo-upload-fail'))
                <div class="alert alert-info alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-info"></i>Photo Upload </h5>
                  {{session('photo-upload-fail')}}
                </div>
              @endempty
                <div class="card-body row">
                  <div class="form-group col-md-4">
                    <label for="Email">*Email </label>
                    <input required type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                    @error('email')
                        <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group col-md-4">
                    <label for="password">*Password</label>
                    <input required type="password" class="form-control" id="password" name="password" placeholder="Password">
                    @error('password')
                        <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group col-md-4">
                    <label for="password">Confirm Password</label>
                    <input required type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
                    @error('password_confirmation')
                        <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group col-md-4">
                    <label for="name">*Full Name </label>
                    <input required type="text" class="form-control" id="name" name="name" placeholder="Enter your full name">
                    @error('name')
                        <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group col-md-4">
                    <label for="position">Administrative Position </label>
                    <input type="text" class="form-control" id="position" name="position" placeholder="Optional">
                    @error('position')
                        <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group col-md-4">
                    <label for="phone">Phone </label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Optional">
                    @error('phone')
                        <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                        <label>Contact Information </label>
                        <textarea class="form-control" rows="3" name="contact" placeholder="Contact Information (Optional)"></textarea>
                    @error('contact')
                        <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                  </div>
                  <div class="form-group col-md-8">
                    <label for="photo">Profile Picture (1MB max, JPEG or PNG.)</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" accept="image/*"
                                id="photo" name="photo"  capture="environment"
                                onchange="document.getElementById('img_preview').src = window.URL.createObjectURL(this.files[0])">
                            <label class="custom-file-label" for="photo">Choose file</label>
                        </div>
                    @error('photo')
                        <div class="alert alert-danger">{{$message}}</div>
                    @enderror            
                    </div>
                    <div class="input-group">
                        <img id="img_preview" alt="" height="100" width="100">
                    </div>
                  </div>
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Add Admin</button>
                </div>
              </form>
            </div>
                    
                    
                </div><!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>


        <x-footer motto="">
            <script src="/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
                <script>
                    $(function () {
                    bsCustomFileInput.init();
                    });
                </script>
        </x-footer>
   